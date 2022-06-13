<?php
namespace App\Model\Entity;

use App\Util\DoubleUtil;
use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

class VistoriaAvaria extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function saveVistoriaAvariaContainer($aData)
    {
        $oResponse = new ResponseUtil();
        $iSituacaoContainerID = EntityUtil::getIdByParams('SituacaoContainers', 'descricao', 'Necessidade de Reparo');

        if (isset($aData['necessita_reparo'])) {
            $oVistoriaItem = LgDbUtil::getByID('VistoriaItens', $aData['vistoria_item_id']);

            if ($oVistoriaItem) {
                $oVistoriaItem->situacao_container_id = $iSituacaoContainerID;
                LgDbUtil::save('VistoriaItens', $oVistoriaItem);
            }
        }

        foreach ($aData['avarias'] as $key => $value) {

            $aDataInsertVistoriaAvarias = [
                'vistoria_id'      => $aData['vistoria_id'],
                'vistoria_item_id' => $aData['vistoria_item_id'],
                'avaria_id'        => $key
            ];

            $oVistoriaAvarias = LgDbUtil::saveNew('VistoriaAvarias', $aDataInsertVistoriaAvarias, true);
            if (!$oVistoriaAvarias) 
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Ocorreu algum erro ao avariar o container');
            
            foreach ($value as $iAvariaRespostaId) {

                $aDataInsertVistoriaAvariaRespostas = [
                    'avaria_id'          => $key,
                    'avaria_resposta_id' => $iAvariaRespostaId,
                    'vistoria_avaria_id' => $oVistoriaAvarias->id
                ];

                $oVistoriaAvariaRespostas = LgDbUtil::saveNew('VistoriaAvariaRespostas', $aDataInsertVistoriaAvariaRespostas);
                if (!$oVistoriaAvariaRespostas) 
                    return $oResponse
                        ->setStatus(400)
                        ->setTitle('Ops!')
                        ->setMessage('Ocorreu algum erro ao avariar resposta do container');
            }

        }

        if (isset($aData['necessita_reparo'])) {

            $oResponse = EntradaSaidaContainer::updateSituacaoContainer($aData['container_id'], $iSituacaoContainerID);

            if ($oResponse->getStatus() != 200)
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Ocorreu algum erro ao atualizar a situação do container');

        }
        
        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Container avariado com sucesso');
    }

    public static function saveVistoriaAvariaCargaGeral($aData)
    {
        $oResponse = new ResponseUtil();

        $aDataInsert = [
            'vistoria_id'      => $aData['vistoria_id'],
            'vistoria_item_id' => $aData['vistoria_item_id'],
            'avaria_id'        => $aData['avaria_id'],
            'volume'           => DoubleUtil::toDBUnformat($aData['volume']),
            'peso'             => DoubleUtil::toDBUnformat($aData['peso']),
            'lacre'            => $aData['lacre'],
        ];

        if (!LgDbUtil::saveNew('VistoriaAvarias', $aDataInsert)) 
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu algum erro ao informar avaria!');

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Avaria informada com sucesso!');
    }

    public static function deleteVistoriaAvaria($iVistoriaAvariaId)
    {
        $oResponse = new ResponseUtil();

        $oEntityVistoriaAvaria = LgDbUtil::get('VistoriaAvarias');

        $oVistoriaAvaria = LgDbUtil::getFirst('VistoriaAvarias', ['id' => $iVistoriaAvariaId]);
        if ($oVistoriaAvaria) {

            if (!$oEntityVistoriaAvaria->delete($oVistoriaAvaria))
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Ocorreu algum erro ao remover a avaria!');

            return $oResponse
                ->setStatus(200)
                ->setTitle('Sucesso!')
                ->setMessage('Avaria removida com sucesso!');

        }

        return $oResponse
            ->setStatus(400)
            ->setTitle('Ops!')
            ->setMessage('Avaria não encontrada!');
    }

}
