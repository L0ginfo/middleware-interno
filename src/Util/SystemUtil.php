<?php

namespace App\Util;

use App\Model\Entity\ParametroGeral;
use DateTimeZone;

class SystemUtil {

    public static function setFusoHorario($bByParameter = false){
        $sTimeZone = SessionUtil::get('FUSO_HORARIO');

        if(empty($_SESSION['FUSO_HORARIO']) || $bByParameter){
            $sTimeZone = ParametroGeral::getParametroWithValue('PARAM_FUSO_HORARIO_PADRAO');
        }

        if (isset($sTimeZone) && in_array($sTimeZone, DateTimeZone::listIdentifiers())) {
            if(date_default_timezone_set($sTimeZone)) SessionUtil::set('FUSO_HORARIO', $sTimeZone , 30);
        }
    }
}