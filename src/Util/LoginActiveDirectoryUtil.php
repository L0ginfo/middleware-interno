<?php

/**
 * Autor: Rodrigo Alves da Silveira
 */

namespace App\Util;

use Cake\ORM\TableRegistry;

use App\Model\Entity\ParametroGeral;

class LoginActiveDirectoryUtil 
{

    private $aServerActiveDirectory;
    private $oConnect;
    private $oLoginActiveDirectory;
    private $sUser;
    private $sPassword;

    public function __construct()
    {
        $oParameter = ParametroGeral::getParameterByUniqueName('LOGIN_ACTIVE_DIRECTORY');


        if(isset($oParameter)){
            $aParameter = json_decode($oParameter->valor, true)?:[];
            $this->aServerActiveDirectory = $this->aFilterValidServers($aParameter);
        }
    }


    private function aFilterValidServers($aData){

        return array_reduce($aData, function($sum, $value){
            if(
                isset($value['conexao_ad']) && 
                isset($value['conexao_ad']['ldap_server']) && 
                isset($value['conexao_ad']['ativo']) && 
                $value['conexao_ad']['ativo'] === true
            ){
                array_push($sum, $value);
            }

            return $sum;

        }, []);
    }

    private function init($sServer, $sUser, $sPassword, $port = 389){

        if(empty($sServer) || empty($sUser) || empty($sPassword)){
            return false;
        }

        if($this->oConnect = @ldap_connect($sServer, $port)){
            ldap_set_option($this->oConnect, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($this->oConnect, LDAP_OPT_REFERRALS, 0);
            ldap_set_option($this->oConnect, LDAP_OPT_NETWORK_TIMEOUT, 10); 

            if($this->oLoginActiveDirectory = @ldap_bind($this->oConnect, $sUser, $sPassword)){
                $this->sUser = $sUser;
                $this->sPassword = $sPassword;
                return $this;
            }
        }

        return false;
    }

    private function connect($sUser, $sPassword){

        if(empty($this->aServerActiveDirectory)){
            return false;
        }

        foreach ($this->aServerActiveDirectory as $server) {
            if($this->init(@$server['conexao_ad']['ldap_server'], $sUser, $sPassword, @$server['conexao_ad']['port'])){                
                return $this;
            }
        }

        return false;
    }

    public function login($aData){

        if ($this->connect(@$aData['cpf'], @$aData['senha'])) {
            return $this->getUser();
        }
            
        return false;
    }



    private function getUser(){

        $oUsuario = LgDbUtil::getFirst('Usuarios', [
            'email' => trim($this->sUser)
        ]);

        if(isset($oUsuario)){
            return $oUsuario;
        }

        $oPerfil = LgDbUtil::getFirst('Perfis', ['nome' => 'Sem perfil']);

        if(empty($oPerfil)){
            return false;
        }

        $oEntity = LgDbUtil::saveNew('Usuarios', [
            'ativo' => 1,
            'cpf' => '----------',
            'senha' => hash('md5', time().$this->sUser),
            'nome' => $this->sUser,
            'email' => $this->sUser,
            'perfil_id' => $oPerfil->id,
            'created_by' => 1
        ], true);

        $oEntity->new = true;
        return $oEntity;
    }

}