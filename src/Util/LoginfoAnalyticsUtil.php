<?php

/**
 * Autor: Silvio Regis da Silva Junior
 */

namespace App\Util;

use Cake\ORM\TableRegistry;

//Caso o sistema atual não tenha a classe "ParametroGeral", comente a linha abaixo
use App\Model\Entity\ParametroGeral;

class LoginfoAnalyticsUtil 
{
    private static $sControllerAnalytics = 'acessos';
    private static $sActionScriptAnalytics = 'getScript';
    
    //Caso o sistema atual não tenha a classe "ParametroGeral", preencha as duas vars abaixo
    private static $sUrlScript = '';
    private static $sTokenScript = '';

    public static function initEntry($oView)
    {
        //Desabilitado a chamada para o Analytics
        return '';
        
        $aParams = [];
        $aParams = self::getParams();

        if (!$aParams)
            return '';
        
        $sLink = $aParams['url'] . self::$sControllerAnalytics . '/' . self::$sActionScriptAnalytics . '/' . $aParams['token'];

        $aData = [
            'perfil'     => self::getPerfil(),
            'nome'      => @$_SESSION['Auth']['User']['nome'],
            'email'      => @$_SESSION['Auth']['User']['email'],
            'pagina'     => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
            'controller' => self::camelToUnderscore($oView->request->params['controller']),
            'action'     => self::camelToUnderscore($oView->request->params['action']),
            'referer'    => $_SERVER['HTTP_HOST']
        ];
        
        echo '<script src='.$sLink.'></script>';
        echo '<script>

            document.addEventListener("DOMContentLoaded", function(event) {
                LoginfoApiUtil.initEntry('.json_encode($aData).')
            });
        
        </script>';

    }

    private static function getParams()
    {
        if (self::$sUrlScript && self::$sTokenScript) {
            return [
                'url' => self::$sUrlScript,
                'token' => self::$sTokenScript
            ];
        }

        //Caso o sistema atual não tenha a classe "ParametroGeral", comente as linhas abaixo
        $oConfig = ParametroGeral::getParameterByUniqueName('LOGINFO_ANALITYCS_CONFIG');

        if (!$oConfig || !$oConfig->valor || !($oConfig = json_decode($oConfig->valor)) || @!$oConfig->url || @!$oConfig->token) {
            return '';
        }

        return [
            'url' => $oConfig->url,
            'token' => $oConfig->token
        ];
    }

    private static function camelToUnderscore($string, $us = "-") {
        return strtolower(preg_replace(
            '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/', $us, $string));
    }

    private static function getPerfil()
    {
        $iPerfilID = @$_SESSION['Auth']['User']['perfil_id'];

        $oPerfil = TableRegistry::getTableLocator()->get('Perfis')->find()->where(['id' => $iPerfilID])->first();

        if ($oPerfil)
            return $oPerfil->nome;

        return 'Sem perfil';
    }

}
