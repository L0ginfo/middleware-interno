<?php 
namespace Util\Core;

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

}