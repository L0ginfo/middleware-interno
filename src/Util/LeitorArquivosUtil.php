<?php 


namespace App\Util;

use App\Model\Entity\ParametroGeral;
use SimpleExcel\SimpleExcel;

class LeitorArquivosUtil {

    public static function getDataAsArray($file_name)
    {
        try {
            return file($file_name);
        } catch (\Throwable $th) {
            echo 'ERROR'. $th ; die;
        }
    }

    public static function getNameFiles($table)
    {
        $dir =  trim(@ParametroGeral::getParameterByUniqueName('INT_SKYLINE_FILES_DIR')->valor?:'');
        return array_filter(scandir($dir), function($file){
            return $file != 'empty' &&  $file != '.' && $file != '..';
        });
    }

    public static function moveFile($path, $name, $table)
    {
        $saveDir = trim(@ParametroGeral::getParameterByUniqueName( 'INT_SKYLINE_FILES_DIR_TO_SAVE')->valor?:'');
        $dir = $saveDir.DS.$name;

        $sNomeArquivoDestino = $dir . '__-__date-' . date('Y-m-d-H-i-s-') . time();

        rename($path, $sNomeArquivoDestino);

        try {
            if (file_exists($path) && @copy($path, $sNomeArquivoDestino))
                unlink($path);
        } catch (\Throwable $th) { 

        }
    }

    public static function getPathFilesNotProcess($file, $table)
    {
        $dir = trim(@ParametroGeral::getParameterByUniqueName( 'INT_SKYLINE_FILES_DIR')->valor?:'');
        return $dir.DS.$file;
    }

    public static function getPath()
    {
        return trim(@ParametroGeral::getParameterByUniqueName('INT_SKYLINE_FILES_DIR')->valor ?:'');
    }

    public function importXLS($arquivo)
    {
        try {

            $excel = new SimpleExcel('xml');
            $excel->parser->loadFile($arquivo);
    
            $aData = [];
            $aData = $excel->parser->getField();
            unset($aData[0]);

            return [
                'message' => __('Arquivo importado com sucesso!'),
                'status'  => 200,
                'data'    => $aData
            ];

        } catch (\Throwable $th) {

            return [
                'message' => __($th->getMessage()),
                'status'  => 400
            ];

        }

    }
    
}


?>