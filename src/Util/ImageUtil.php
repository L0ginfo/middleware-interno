<?php

/**
 * Autor: Silvio Regis da Silva Junior
 */

namespace App\Util;

use App\Model\Entity\ParametroGeral;

class ImageUtil {

    public static function getImageNameFromPath($sImagePath)
    {
        return $sImagePath;

        $sImagePath = explode('/', $sImagePath);
        $sImagePath = $sImagePath[count($sImagePath) - 1];
    }

    public static function getImagePdf($sImagePath){

        if(empty($sImagePath)) {
            $sImagePath = '/img/'.ParametroGeral::getParametroWithValue(
                'LOGO_MENU_HOVER'
            );
        }

        return self::getImageNameFromPath($sImagePath);
    }

}