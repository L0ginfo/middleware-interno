<?php 

namespace App\Util;
use Cake\I18n\I18n;;


class RealNumberUtil
{


    /*
        Converte Numero para banco de dados
    */
    public static function convertNumberToDB($number){
        if (I18n::getLocale() === 'pt_BR')
            return str_replace(',','.',str_replace('.','', $number));
        return $number;
    }

    /*
        Converte Numero para tela
    */
    public static function convertNumberToView($number, $decimals = 0){
        if (I18n::getLocale() === 'pt_BR')
            return number_format ($number,$decimals,',','.');
        return number_format ($number, $decimals,'.',',');
    }


    public static function convertNumberFromIntegration($value){
        return substr($value, 0, -2).'.'.substr($value, -2);
    }

}