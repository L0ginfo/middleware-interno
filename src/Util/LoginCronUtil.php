<?php

/**
 * Autor: Silvio Regis da Silva Junior
 */

namespace App\Util;

class LoginCronUtil {
    protected static $iUsuarioCronID = 150;

    public static function login($that)
    {
        if (!$that->Auth->user() && $that->request->query('cron') == 'true') {
            $that->loadModel('Usuarios');
            $user = $that->Usuarios->get(self::$iUsuarioCronID);
            $that->Auth->setUser($user);
        }
    }

    public static function loginForIntegration($that)
    {
        if (!$that->Auth->user() && $that->request->query('psmtq') == 'true') {
            $that->loadModel('Usuarios');
            $user = $that->Usuarios->get(self::$iUsuarioCronID);
            $that->Auth->setUser($user);
        }
    }

    public static function logout($that)
    {
        if ($that->Auth->user() && ($that->request->query('cron') == 'true' || $that->Auth->user('id') == self::$iUsuarioCronID)) 
            $that->Auth->logout();
    }
}