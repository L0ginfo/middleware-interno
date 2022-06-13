<?php

ini_set('display_errors', 'off');
ini_set('error_log', 'log/monitor.log');
set_include_path(get_include_path() . PATH_SEPARATOR .  './lib/');

$config = include 'config.php';

include_once 'dbportal.php';
include_once 'dbsara.php';
include_once 'pdfmaker.php';
include_once 'myview.php';


$pdf = pdfmaker::make('pdf001', ['NUM_NFSE' => '000000589']);
// $pdf = pdfmaker::make('pdf001', ['NFM_ID' => 381]);
file_put_contents("teste.pdf", $pdf);


// file_put_contents("201600000217.pdf", pdfmaker::make('pdf005', ['LOTE_ID' => '201600000217']));
//file_put_contents("201600000237.pdf", pdfmaker::make('pdf005', ['LOTE_ID' => '201600000237']));
//file_put_contents("201600000133.pdf", pdfmaker::make('pdf005', ['LOTE_ID' => '201600000133']));
//file_put_contents("201600000011.pdf", pdfmaker::make('pdf005', ['LOTE_ID' => '201600000011']));







