<?php
namespace App\Http\Session;

use App\Model\Entity\ParametroGeral;
use App\Util\DeviceDetectUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use App\Util\SessionUtil;

class ManageSessionUser 
{
    public static function do($aUsuario)
    {
        $oResponse = new ResponseUtil;

        if (!$aUsuario || !@$aUsuario['id'])
            return $oResponse->setStatus(200);
        
        $sParam = ParametroGeral::getParametroWithValue('PARAM_CONTROLE_ACESSO_SIMULTANEO_POR_USER');
        $sParam = json_decode($sParam);

        if (!$sParam || @!$sParam->ativo || @!$sParam->maximo_sessoes_simultaneas_por_usuario)
            return $oResponse->setStatus(200);

        $aControleSessoes = LgDbUtil::getAll('ControleSessoes', ['usuario_id' => $aUsuario['id']]);

        if (count($aControleSessoes) + 1 > $sParam->maximo_sessoes_simultaneas_por_usuario)
            return $oResponse
                ->setTitle('Limite de sessões simultâneas atingido!')
                ->setMessage(self::getMessage($aControleSessoes));

        return $oResponse->setStatus(200);
    }

    private static function getMessage($aControleSessoes)
    {
        $aHtml = ['Abaixo, seguem os dispositivos que você está conectado. Favor <b style="color:red">desconecte</b> sua sessão de algum deles:<br><br>'];

        foreach ($aControleSessoes as $iKey => $aControleSessao) {
            $oDevice = new DeviceDetectUtil($aControleSessao->user_agent); 
            
            $aHtml[] = '<div style="margin-bottom: 10px">' . ($iKey + 1) . ' - <b>Tipo Dispositivo:</b> "<i style="color:red">' . $oDevice->getDeviceType() . '</i>", <b>descrição:</b>  ('.$oDevice->getDeviceMatched().') ' . '</div>';
        }

        return implode('', $aHtml);
    }
}