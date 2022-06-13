<?php

/**
 * Autor: Silvio Regis da Silva Junior
 */

namespace App\Util;

use Cake\Http\Session;
use DateTime;

class SessionUtil {
    
    /**
     * Utilização:
     * 
     * $uData = SessionUtil::cacheData('chave-unica-a-ser-posta-em-cache', function() {
     *      // all routine action
     *  }, 2);
     */
    public static function cacheData($uKeyCache, $fData, $iMaxMinutesInCache)
    {
        // $uDataSession      = @Session::create()->read($uKeyCache);
        $uDataSession      = @$_SESSION[$uKeyCache];
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

    public static function getCacheData($uKeyCache){
        try {
            return @Session::create()->read($uKeyCache);
        } catch (\Throwable $th) {
            return null;
        }
    }

    public static function get($uKeyCache){
        try {
            return @$_SESSION[$uKeyCache];
        } catch (\Throwable $th) {
            return null;
        }
    }

    public static function set($uKeyCache, $uData){
        $_SESSION[$uKeyCache] = $uData;
    }

    public static function getUsuarioConectado()
    {
        return @$_SESSION['Auth']['User']['id'];
    }

    public static function getPerfilUsuario()
    {
        return @$_SESSION['Auth']['User']['perfil_id'];
    }

}