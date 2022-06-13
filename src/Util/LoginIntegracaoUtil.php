<?php

/**
 * Autor: Silvio Regis da Silva Junior
 */

namespace App\Util;

class LoginIntegracaoUtil {
    protected static $iUsuarioID = 1;
    protected static $bIslogged = false;

    public static function login($that)
    {
        if (!$that->Auth->user()) {
            $that->loadModel('Usuarios');
            $user = $that->Usuarios->get(self::$iUsuarioID);
            $that->Auth->setUser($user);
        } else {
            self::$bIslogged = true;
        }
    }

    public static function logout($that)
    {
        if ($that->Auth->user() && !self::$bIslogged) 
            $that->Auth->logout();

        self::$bIslogged = false;
    }
}