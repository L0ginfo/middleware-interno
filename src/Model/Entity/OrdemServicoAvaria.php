<?php
namespace App\Model\Entity;

use App\Util\DoubleUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

class OrdemServicoAvaria extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function saveAvaria($aData)
    {
        $oResponse = new ResponseUtil();

        $aDataInsert = [
            'ordem_servico_id' => $aData['iOSID'],
            'container_id'     => $aData['iContainerID'],
            'avaria_id'        => $aData['iAvariaID'],
            'volume'           => DoubleUtil::toDBUnformat($aData['iVolume']),
            'peso'             => @$aData['iPeso'] ? DoubleUtil::toDBUnformat($aData['iPeso']) : 0,
            'observacoes'      => $aData['obs'],
            'avaria_tipo_id'   => $aData['iAvariaTipoID'],
        ];

        $oOrdemServicoAvaria = LgDbUtil::saveNew('OrdemServicoAvarias', $aDataInsert, true);

        if ($oOrdemServicoAvaria->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('ocorreu um erro ao editar a Ordem Serviço Item!');

        $aOrdemServicoAvarias = self::getAvarias($aData['iOSID'], $aData['iContainerID']);

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Avaria cadastrada com sucesso!')
            ->setDataExtra($aOrdemServicoAvarias);
    }

    public static function getAvarias($iOSID, $iContainerID, $bReturnResponse = false)
    {
        $aOrdemServicoAvarias = LgDbUtil::getFind('OrdemServicoAvarias')
            ->contain(['Avarias', 'AvariaTipos'])
            ->where([
                'ordem_servico_id' => $iOSID,
                'container_id'     => $iContainerID
            ])
            ->toArray();

        $aOrdemServicoAvarias = json_decode(json_encode($aOrdemServicoAvarias), true);

        if ($bReturnResponse)
            return (new ResponseUtil())
                ->setStatus(200)
                ->setDataExtra($aOrdemServicoAvarias);
    
        return $aOrdemServicoAvarias;
    }

    public static function removeAvarias($oData)
    {
        $oResponse = new ResponseUtil();

        $oOrdemServicoAvaria = LgDbUtil::getByID('OrdemServicoAvarias', $oData['iOSAvairaID']);
        if (!$oOrdemServicoAvaria)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('A avaria não foi encontrada!');

        $iOSID        = $oOrdemServicoAvaria->ordem_servico_id;
        $iContainerID = $oOrdemServicoAvaria->container_id;

        if (!LgDbUtil::get('OrdemServicoAvarias')->delete($oOrdemServicoAvaria))
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Não foi possível remover a Avaria!');

        $aOrdemServicoAvarias = self::getAvarias($iOSID, $iContainerID);

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Avaria removida com sucesso!')
            ->setDataExtra($aOrdemServicoAvarias);
    }

}
