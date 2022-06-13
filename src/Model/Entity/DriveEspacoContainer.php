<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\Http\Client\Response;
use Cake\ORM\Entity;

class DriveEspacoContainer extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function verifyCaracteristicasContainer($iDriveEspacoID, $iContainerID)
    {
        $oResponse = new ResponseUtil;
        $oDriveEspaco = LgDbUtil::getByID('DriveEspacos', $iDriveEspacoID);

        if (Resv::isDescarga(null, $oDriveEspaco->operacao_id))
            return $oResponse->setStatus(200);

        //As proximas validações são para a carga:
        
        $oEstoqueEnderecoContainer = LgDbUtil::getFirst('EstoqueEnderecos', [
            'container_id' => $iContainerID
        ]);

        if (!$oEstoqueEnderecoContainer)
            return $oResponse->setMessage('O container não está no estoque!');

        if (DriveEspacoClassificacao::isVazio($oDriveEspaco->drive_espaco_classificacao_id)) {
            if (!Container::isContainerVazio($oEstoqueEnderecoContainer))
                return $oResponse->setMessage('O container está no estoque mas não é um container vazio!');
            else 
                return $oResponse->setStatus(200);
        }

        if (DriveEspacoClassificacao::isCheio($oDriveEspaco->drive_espaco_classificacao_id)) {
            if (!Container::isContainerCheio($oEstoqueEnderecoContainer))
                return $oResponse->setMessage('O container está no estoque mas não é um container cheio!');
            else 
                return $oResponse->setStatus(200);
        }

        return $oResponse->setStatus(200);
    }

    public static function addContainer($aData)
    {
        $oResponse = new ResponseUtil();

        $oResponse = self::verifyLimiteContainers($aData['drive_espaco_id']);
        if ($oResponse->getStatus() != 200)
            return $oResponse;

        $oResponse = self::verifyCaracteristicasContainer($aData['drive_espaco_id'], $aData['container_id']);
        if ($oResponse->getStatus() != 200)
            return $oResponse;

        $aDataInsert = [
            'drive_espaco_id' => $aData['drive_espaco_id'],
            'container_id'    => $aData['container_id']
        ];

        $oDriveEspacoContainer = LgDbUtil::getFirst('DriveEspacoContainers', $aDataInsert);
        if ($oDriveEspacoContainer)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Esse container já está cadastrado nesse drive de espaço.');

        if (!LgDbUtil::saveNew('DriveEspacoContainers', $aDataInsert))
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Occoreu algum erro ao adicionar container no drive de espaço.');

        $oResponse = self::vinculaDriveEspacoAtual($aData['container_id'], $aData['drive_espaco_id']);

        if ($oResponse->getStatus() != 200)
            return $oResponse;
                
        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Container adicionado ao drive de espaço com sucesso.');

    }

    public static function verifyLimiteContainers($iDriveEspacoID)
    {
        $oResponse = new ResponseUtil();

        $oDriveEspaco = LgDbUtil::getFind('DriveEspacos')
            ->contain(['DriveEspacoContainers'])
            ->where(['id' => $iDriveEspacoID])
            ->first();

        $iQuantidadeMaxima = $oDriveEspaco->qtde_container_vazio_carga + $oDriveEspaco->qtde_container_vazio_descarga + $oDriveEspaco->qtde_container_cheio_carga + $oDriveEspaco->qtde_container_cheio_descarga;
        if ($iQuantidadeMaxima == 0)
            return $oResponse
                ->setStatus(200);

        if (count($oDriveEspaco->drive_espaco_containers) < $iQuantidadeMaxima)
            return $oResponse
                ->setStatus(200);

        return $oResponse
            ->setStatus(400)
            ->setTitle('Ops!')
            ->setMessage('O drive de espaço já alcançou o limite de containers.');
    }

    private static function vinculaDriveEspacoAtual($iContainerID, $iDriveEspacoID)
    {
        $oResponse = new ResponseUtil();

        $oEntradaSaidaContainers = EntradaSaidaContainer::getLastByContainerId($iContainerID);

        if (!$oEntradaSaidaContainers)
            return $oResponse->setStatus(200);

        $oResponse = EntradaSaidaContainer::setDriveEspacoAtual($iContainerID, (int)$iDriveEspacoID);

        return $oResponse;
    }
}
