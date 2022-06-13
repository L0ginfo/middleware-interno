<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

class EntradaSaidaContainerVistoria extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function saveEntradaSaidaContainerVistoria($iVistoriaID)
    {
        $oResponse = new ResponseUtil();

        $oVistoria = LgDbUtil::getFind('Vistorias')
            ->contain(['VistoriaItens'])
            ->where(['id' => $iVistoriaID])
            ->first();

        if (!$oVistoria->vistoria_itens)
            return $oResponse
                ->setStatus(200);

        foreach ($oVistoria->vistoria_itens as $oItem) {

            if (!$oItem->container_id)
                break;
                
            $aConditions            = EntradaSaidaContainer::getConditionsByContainerId($oItem->container_id);
            $oEntradaSaidaContainer = LgDbUtil::getFirst('EntradaSaidaContainers', $aConditions, ['id' => 'DESC']);

            if (!$oEntradaSaidaContainer)
                break;

            $aDataInsert = [
                'entrada_saida_container_id' => $oEntradaSaidaContainer->id,
                'vistoria_id'                => $iVistoriaID,
            ];

            if (!LgDbUtil::saveNew('EntradaSaidaContainerVistorias', $aDataInsert))
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Ocorreu um erro ao registrar a vistoria na entrada ou saída do container.');

        }

        return $oResponse
            ->setStatus(200);
    }

}
