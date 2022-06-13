<?php

/**
 * Autor: Silvio Regis da Silva Junior
 */

namespace App\Util;

class MaskUtil
{
    static function mask($val, $mask)
    {
        $maskared = '';
        $k = 0;

        for($i = 0; $i<=strlen($mask)-1; $i++){
            if($mask[$i] == '#'){
                if(isset($val[$k]))
                    $maskared .= $val[$k++];
            }else{
                if(isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }


    static function maxWidth($input, $width){
        return mb_strimwidth($input, 0, $width);
    }
}
