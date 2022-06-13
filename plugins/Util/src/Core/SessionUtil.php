<?php

namespace App\Util;

use Cake\Http\Session;
use DateTime;

class SessionUtil {
    
    public static function cacheData($uKeyCache, $fData, $iMaxMinutesInCache)
    {
        $uDataSession      = @Session::create()->read($uKeyCache);
        $oDateWrited       = @$uDataSession['start'];
        $iMinutesInSession = 0;

        if ($oDateWrited) {
            $oDateDiff         = $oDateWrited->diff(new DateTime());
            $iMinutesInSession = $oDateDiff->i;
        }
        
        if (!$uDataSession || ($uDataSession && $iMinutesInSession >= $iMaxMinutesInCache)) {
            $uData = $fData();
            @Session::create()->write($uKeyCache, [
                'uData' => $uData,
                'start' => new DateTime()
            ]);
        }else {
            $uData = $uDataSession['uData'];
        }

        return $uData;
    }

}