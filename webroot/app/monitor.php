<?php

ini_set('display_errors', 'off');
ini_set('error_log', 'log/monitor-'.date('Y-m-d').'.log');
set_include_path(get_include_path() . PATH_SEPARATOR .  './lib/');

$config = include 'config.php';

include_once 'dbportal.php';
include_once 'dbsara.php';
include_once 'pdfmaker.php';
include_once 'myview.php';

$params = [date('d/m/Y', strtotime("-1 day")), date('d/m/Y')];

$notas = dbsara::fetchAll("SELECT
SEM_BOLETO, A1_NOME NOME_CLIENTE, A1_EMAIL EMAIL, EMAIL_COMISSARIA, NUM_NFSE, SERIE_NFSE, COD_NFSE, RPS_PROTHEUS
FROM v_loginfo_demon_calculo
WHERE EMAIL_ENVIADO <> 'S' AND CONVERT(VARCHAR, GERACAO_HORA, 103) BETWEEN '".$params[0]."' AND '".$params[1]."'
ORDER BY NUM_NFSE DESC", []);

foreach($notas as $nota) {

    $nNota = intval(ltrim($nota['NUM_NFSE'], '0'));
	if (!$nNota) continue;

    error_log("Processando NFSE $nNota");

    if (!$nota || (!$nota['EMAIL'] && !$nota['EMAIL_COMISSARIA'])) {
        error_log("Emails not found NUM_NFSE = $nNota, fields EMAIL and EMAIL_COMISSARIA ");
        error_log(print_r($nota, true));
        continue;
    }

    $attachs = [];

	$nota['EMAIL'] = trim($nota['EMAIL']) . ';' . $nota['EMAIL_COMISSARIA'] ?: '';

    $url = sprintf($config['nfse-itajai-url'], $nNota, trim($nota['SERIE_NFSE']), preg_replace('/[^0-9]/', '', $config['nfse-itajai-cnpj']), trim($nota['COD_NFSE']) );

    $pdf = file_get_contents($url);
    if (strlen($pdf) < 8*1024) {
        // arquivo muito pequeno, ??erro?? ao pegar o pdf
        error_log("Cannot download url: $url");
        continue;
    } else {
        $file_nota = 'temp/'.'nfse_'.$nota['NUM_NFSE'].'.pdf';
        file_put_contents($file_nota, $pdf);
        $attachs["$nNota-nfse.pdf"] = $file_nota;
    }

    if (!$nota['SEM_BOLETO']) {
        $file_boleto_from = $config['boleto-path'].'boleto_'.$nota['NUM_NFSE'].'.pdf';
        $file_boleto_to = 'temp/'.'boleto_'.$nota['NUM_NFSE'].".pdf";

        if (is_readable($file_boleto_from)) {
            rename($file_boleto_from, $file_boleto_to);
            $attachs["$nNota-boleto.pdf"] = $file_boleto_to;
        } else {
            error_log("File not found: $file_boleto_from");
            continue;
        }
	}

	try {
		$pdf = pdfmaker::make('pdf001', ['NUM_NFSE' => str_pad($nNota, 9, '0', STR_PAD_LEFT)]);
		$file_demo = 'temp/'.'demo_'.$nota['NUM_NFSE'].'.pdf';
		file_put_contents($file_demo, $pdf);
		$attachs["$nNota-demo.pdf"] = $file_demo;
	} catch (Exception $e) {
		error_log('Erro ao gerar Demonstrativo '.$e->getMessage());
		continue;
	}

    foreach($attachs as $name => $filename)
        copy($filename, $config['boleto-path'].'enviados/'.$name);

	$mailParams = [
		'PROFILE' => 'nfe',
		'TO_EMAIL' => $nota['EMAIL'],
		'SUBJECT' => "NFE e Boleto - ".$config['EMPRESA'],
		'MESSAGE' => myview::render('views/email-NF.phtml', $nota),
		'HTML' => 1,
		'ATTACHS' => $attachs,
	];

	//echo 'enviando...'."\r\n";
	// $mailParams['TO_EMAIL'] = 'luiz@webprofire.com.br;felippe@loginfo.com.br;isabella.tasso@barradorio.com.br';

    //dbsara::exec("update protheus11..SF3010 set F3_ZENVMSN = 'S' where F3_NFISCAL = ? and F3_NFELETR = ? and F3_SERIE = ?", [$nota['RPS_PROTHEUS'], $nota['NUM_NFSE'], $nota['SERIE_NFSE']]);
	dbsara::exec("update protheus11..SF3010 set F3_ZENVMSN = 'S' where F3_NFISCAL = ? and F3_SERIE = ?", [$nota['RPS_PROTHEUS'], $nota['SERIE_NFSE']]);
	dbportal::sendMail($mailParams);

}

error_log('Processado!');
