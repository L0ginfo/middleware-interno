<?php

ini_set('display_errors', 'off');
ini_set('error_log', 'log/getpdf.log');
set_include_path(get_include_path() . PATH_SEPARATOR .  './lib/');

$config = include 'config.php';

include_once 'dbportal.php';
include_once 'dbsara.php';
include_once 'pdfmaker.php';

// remove o &check=XXXXXXXXXX para calcular o check
$query = preg_replace('/[^A-Za-z0-9]check=[A-Fa-f0-9]*/i', '', $_SERVER['QUERY_STRING']);
$check = md5($config['md5-salt'].$query);
// error_log($query);
$_REQUEST['params']['url'] = $config['base-url'] . '/app/getpdf.php?' . $_SERVER['QUERY_STRING'];
// error_log($_REQUEST['check'].'-----'. $check);
if ($_REQUEST['check'] == $check) {
	$pdf = pdfmaker::make($_REQUEST['layout'], $_REQUEST['params']);
	header("Content-type:application/pdf");
	echo $pdf;
} else {
	echo 'Documento invalido';
}


// \\barra-apl01\SARA\OrdemServico