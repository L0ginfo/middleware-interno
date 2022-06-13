<?php

ini_set('display_errors', 'off');
ini_set('error_log', 'log/getzip.log');
set_include_path(get_include_path() . PATH_SEPARATOR .  './lib/');

$config = include 'config.php';

include_once 'dbportal.php';
include_once 'dbsara.php';

// remove o &check=XXXXXXXXXX para calcular o check
$query = preg_replace('/[^A-Za-z0-9]check=[A-Fa-f0-9]*/i', '', $_SERVER['QUERY_STRING']);
$check = md5($config['md5-salt'].$query);
// error_log($query);
$_REQUEST['params']['url'] = $config['base-url'] . '/app/getfile.php?' . $_SERVER['QUERY_STRING'];
// error_log($_REQUEST['check'].'-----'. $check);
if (!$_REQUEST['check'] == $check) {
	echo 'Documento invalido';
	return;
}


if ($_REQUEST['layout'] == 'fotos-da-os' && $_REQUEST['params']['id']) {
	$id = intval($_REQUEST['params']['id']);

	$zipFile = makeZip(removerArquivos(glob("//barra-apl01/SARA/OrdemServico/$id/*.*")));
	header("Content-type:application/zip");
	header('Content-Disposition: attachment; filename="fotos-da-os-'.$id.'.zip');
	readfile($zipFile);
}
if ($_REQUEST['layout'] == 'fotos-do-lote' && $_REQUEST['params']['id']) {
	$id = intval($_REQUEST['params']['id']);
	$id = str_replace("-","/",$_REQUEST['params']['id']);


	$zipFile = makeZip(removerArquivos(glob("//barra-apl01/SARA/OrdemServico/$id/*.*")));
	header("Content-type:application/zip");
	header('Content-Disposition: attachment; filename="fotos-do-lote-'.$id.'.zip');
	readfile($zipFile);
}


function makeZip($files, $zipFile = '')
{
    if (!$zipFile) $zipFile = tempnam('', 'zip-');

    $zip = new ZipArchive();
    $zip->open($zipFile, ZIPARCHIVE::CREATE);

    foreach($files as $name => $filename) {

        if (is_string($name))
            $zip->addFile($filename, $name);
        else
            $zip->addFile(utf8_encode($filename), basename($filename));
}
    $zip->close();

    return $zipFile;
}

function removerArquivos($files){
$arquivos_desejados = [];
	foreach($files as $name => $filename) {
		if ( stristr($filename, '.zip') === FALSE and stristr($filename, '.db') === FALSE)  {
		       $arquivos_desejados[] = $filename;
		}
	}
return $arquivos_desejados;
}

















