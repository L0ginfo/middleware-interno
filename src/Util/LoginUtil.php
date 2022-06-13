<?php

/**
 * Autor: Rodrigo Alves da Silveira
 */

namespace App\Util;

use App\Exception\SaraLoginException;
use App\Model\Entity\Empresa;
use Cake\ORM\TableRegistry;

use App\Model\Entity\ParametroGeral;
use App\RegraNegocio\ControleCampos\ControleCamposManager;

class LoginUtil 
{

    static function setLoginUser($that, $oUsuario){
        try {
            $that->loadModel('Perfis');
            $that->loadModel('EmpresasUsuarios');
            $that->Auth->setUser($oUsuario);

            $aWhere = LgDbUtil::setDataFormatWhere('validade', '>=');

            $empresasUsuarios = $that->EmpresasUsuarios->find()
                ->contain('Empresas')
                ->where([
                    'usuario_id' => $oUsuario['id'],
                    'master' => '1'
                ] + $aWhere)->first();

            // procurando a empresa padrão
            if (!$empresasUsuarios) {
                $empresasUsuarios = $that->Usuarios->EmpresasUsuarios
                    ->find()
                    ->contain('Empresas')
                    ->where(['usuario_id' => $oUsuario['id']])->first();
            }

            $oParametro = ParametroGeral::getParametroWithValue('PARAM_HABILITA_LOG_ACESSO');
            $that->getRequest()->getSession()->write('log_acessos', $oParametro);
            $that->getRequest()->getSession()->write('empresa_id', Empresa::getEmpresaPadrao());
            $that->getRequest()->getSession()->write('empresa_atual', Empresa::getEmpresaPadrao());
            $that->getRequest()->getSession()->write('nome_empresa', Empresa::getEmpresaPadrao());
            SystemUtil::setFusoHorario(true); 
            ControleCamposManager::initCache();   
            return $oUsuario;

        } catch (SaraLoginException $th) {
            $that->Flash->error(__('Senha divergente com o sistema de integração'), 'default', [], 'auth');
            return false;
        }
        
    }

    public static function validateLoginByComputer($that, $oUsuario, $aData)
    {
        $oPerfil = LgDbUtil::getByID('Perfis', $oUsuario['perfil_id']);
        $aUsuarioComputadores = LgDbUtil::getFind('UsuarioComputadores')
            ->contain('Computadores')
            ->where(['usuario_id' => $oUsuario['id']])
            ->toArray();

        $aUsuarioComputadores = array_reduce($aUsuarioComputadores, function($carry, $oUsuarioComputador) {
            $carry[$oUsuarioComputador->computador->hostname] = $oUsuarioComputador->computador->uuid;
            return $carry;
        });

        if (!$aUsuarioComputadores)
            $aUsuarioComputadores = [];

        if(!isset($_SESSION)) session_start(); 
        if (!isset($_SESSION['hostname']) && !isset($_SESSION['uuid'])) {
            $_SESSION['hostname'] = @$aData['hostname'];
            $_SESSION['uuid'] = @$aData['uuid'];
        }

        if (@$oPerfil->validate_login) {
            if (empty($_SESSION['hostname']) && empty($_SESSION['uuid']))
                return (new ResponseUtil())
                    ->setMessage('Necessário logar através do executável.');

            if (!in_array($_SESSION['hostname'], array_keys($aUsuarioComputadores))
                || !in_array($_SESSION['uuid'], $aUsuarioComputadores))
                return (new ResponseUtil())
                    ->setMessage('Este computador não está vinculado ao seu usuário.');


        }

        return (new ResponseUtil())
            ->setStatus(200)
            ->setMessage('Necessário logar através do executável.');
    }

    public static function createRecoveryToken($that, $oUsuario, $iExpirationMinutes = 15)
    {
        $created_at = DateUtil::defautDatetime();
        $expire_at = $created_at->modify('+15 minutes'); //15min
        
        $sToken = md5($oUsuario->cpf.$oUsuario->id);
        $oUsuario->token_recovery = $sToken;
        $oUsuario->token_expiration = $expire_at;
        if($sToken && $that->Usuarios->save($oUsuario)){
            return true;
        }
        return false;
    }


    public static function validRecoveryToken($that, $sToken)
    {
        $oUsuario = LgDbUtil::getFirst('Usuarios',['token_recovery' => $sToken]);

        //Se não encontrar ninguem
        if(!$oUsuario){
            return false;
        }  
        //Se não estiver válido
        if(DateUtil::defautDatetime()->format('Ymdhis') > $oUsuario->token_expiration->format('Ymdhis')) {
            //criar rotina limpar token
            return false;
        }
        //Extra: Se o hash confere
        if(md5($oUsuario->cpf.$oUsuario->id) === $sToken){
            return true;
        }
        return false;
    }

    public static function autenticaViaCertificado($oThat) 
	{
		$sHost = explode('.', $_SERVER['SERVER_NAME']);
		$sSubdomain = $sHost[0];
		$aDataCert = @$oThat->request->data()['cert_loginfo'];
		
		if (!isset($aDataCert) || !isset($aDataCert['cpf']) || !isset($aDataCert['time']) || !isset($aDataCert['token_retorno']))
			return false;
		
		$aTokenExplode = explode(':', base64_decode($aDataCert['token_retorno']));
		
		if (strpos($sSubdomain, $aTokenExplode[1]) === false)
			return false;
		
		$sCpf = $aDataCert['cpf'];
		$oUsuario = $oThat->Usuarios->find()->where(['cpf' => $sCpf])->first();
		$aUsuario = [];
		
		if ($oUsuario)
			$aUsuario = json_decode(json_encode($oUsuario), true);
		
		return $aUsuario;
	}

}