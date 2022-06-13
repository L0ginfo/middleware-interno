<?php

ini_set('display_errors', 'off');
ini_set('error_log', 'log/monitor.log');
set_include_path(get_include_path() . PATH_SEPARATOR .  './lib/');

$nnota = '133';
$serie = 'A1';
$chave = '846A-3364';
$cnpj = '06989608000177';

//"http://nfse.itajai.sc.gov.br/nfse/NFES?nfp_numero=1680&nfp_serie=A1&nfp_tipo=1&cdt_cnpjcpf=04912992000184&chave_validacao=09A8-11E0"

// $nnota = '1680';
// $serie = 'A1';
// $chave = '09A8-11E0';
// $cnpj = '04912992000184';

$urlNFSE = "http://nfse.itajai.sc.gov.br/nfse/NFES?nfp_numero=$nnota&nfp_serie=$serie&nfp_tipo=1&cdt_cnpjcpf=$cnpj&chave_validacao=$chave";
$pdf = file_get_contents($urlNFSE);
file_put_contents("nfse_$nnota.pdf", $pdf);

