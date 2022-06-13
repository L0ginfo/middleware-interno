<?php 

/**
 * Autor: Silvio Regis da Silva Junior
 */

namespace App\Util;

use Exception;

class ErrorUtil {

    public static function custom($sMessage, $aData = [])
    {
        array_merge($aData, [
            'error_level' => 1
        ]);

        throw new Exception(__($sMessage), 1);

        die;
    }

    public static function try($fClosure)
    {
        $oResponse = new ResponseUtil();
        
        try {
            return $fClosure();
        } catch (\Throwable $th) {

            $sError = $th->getFile() . ' on ' . $th->getLine() . '<br>';
            $sError .= $th->getMessage();

            return $oResponse
                ->setError($sError);
        }
    }

    public static function render($that, $aData){
        $that->set($aData);
        $that->render('../Element/Mensagens/error');
    }
}