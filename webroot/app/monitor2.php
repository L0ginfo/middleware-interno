<?php

ini_set('display_errors', 'off');
ini_set('error_log', 'log/monitor-'.date('Y-m-d').'.log');
set_include_path(get_include_path() . PATH_SEPARATOR .  './lib/');

$config = include 'config.php';

include_once 'dbportal.php';
include_once 'dbsara.php';
include_once 'pdfmaker.php';
include_once 'myview.php';

die;

$notas = dbsara::fetchAll("select
A1_NOME NOME_CLIENTE, A1_EMAIL EMAIL, EMAIL_COMISSARIA, NFM_ID
from v_loginfo_demon_calculo_zeradas
where EMAIL_ENVIADO <> 'S'", []);

foreach($notas as $nota) {

    $nfm_id = intval(ltrim($nota['NFM_ID'], '0'));
	if (!$nfm_id) continue;

    error_log("Processando NFM_ID $nfm_id");

    if (!$nota || (!$nota['EMAIL'] && !$nota['EMAIL_COMISSARIA'])) {
        error_log("Emails not found nfm_id = $nfm_id, fields EMAIL and EMAIL_COMISSARIA");
        continue;
    }

    $attachs = [];

	$nota['EMAIL'] = trim($nota['EMAIL']) . ';' . $nota['EMAIL_COMISSARIA'] ?: '';

	try {
		$pdf = pdfmaker::make('pdf001', ['NFM_ID' => $nfm_id]);
		$file_demo = 'temp/'.'demo_c'.$nfm_id.'.pdf';
		file_put_contents($file_demo, $pdf);
		$attachs["d$nfm_id-demo.pdf"] = $file_demo;
	} catch (Exception $e) {
		error_log('Erro ao gerar Demonstrativo '.$e->getMessage());
		continue;
	}

    foreach($attachs as $name => $filename)
        copy($filename, $config['boleto-path'].'enviados/'.$name);

	$mailParams = [
		'PROFILE' => 'nfe',
		'TO_EMAIL' => $nota['EMAIL'],
		'SUBJECT' => "Demonstrativo - ".$config['EMPRESA'],
		'MESSAGE' => myview::render('views/email-demo.phtml', $nota),
		'HTML' => 1,
		'ATTACHS' => $attachs,
	];

	//echo 'enviando...'."\r\n";
	// $mailParams['TO_EMAIL'] = 'luiz@webprofire.com.br;elton@loginfo.com.br';//;isabella.tasso@barradorio.com.br';

    dbsara::exec('insert into tab_loginfo_demon_fat_sem_nf (nfm_id, email_enviado) values (?, ?)', [$nfm_id, 'S']);
	dbportal::sendMail($mailParams);

}

error_log('Processado!');
