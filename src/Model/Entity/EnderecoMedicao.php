<?php
namespace App\Model\Entity;

use App\Util\DateUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use App\Util\SessionUtil;
use Cake\I18n\Time;
use Cake\ORM\Entity;

class EnderecoMedicao extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function generateByCsv($aDataInsert, $sData)
    {
        $oResponse = new ResponseUtil();

        $aDataInsertMedicao = [
            'data_medicao' => DateUtil::dateTimeToDB(new Time($sData)),
            'created_by'   => SessionUtil::getUsuarioConectado()
        ];

        $oEnderecoMedicao = LgDbUtil::saveNew('EnderecoMedicoes', $aDataInsertMedicao, true);
        if ($oEnderecoMedicao->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Erro ao salvar o Endereço Medição!');

        foreach ($aDataInsert as $key => $aData) {
            
            $aData = array_values($aData);
            
            $aDataInsertDados = [
                'endereco_medicao_id' => $oEnderecoMedicao->id,
                'endereco_id'         => $aData[0],
                'area_m2'             => $aData[1],
                'volume_m3'           => $aData[2]
            ];

            $oEnderecoMedicaoDados = LgDbUtil::saveNew('EnderecoMedicaoDados', $aDataInsertDados, true);

            if ($oEnderecoMedicaoDados->hasErrors())
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Erro ao cadastrar um dos registros desse CSV! Favor revisar os dados.');

        }

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Registros importados com sucesso!');
    }

    public static function getDadosComparacao($aDataPost)
    {
        $oResponse = new ResponseUtil();

        if (!$aDataPost['data_medicao_esquerda'] || !$aDataPost['data_medicao_direita'])
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('É necessário selecionar 2 Datas de Medição!');

        $oResponse = self::checkRegistroDatas($aDataPost);
        if ($oResponse->getStatus() != 200)
            return $oResponse;

        $oDataTotal = LgDbUtil::getFind('EnderecoMedicaoDados')
            ->contain('EnderecoMedicoes')
            ->where(['EnderecoMedicoes.data_medicao' => $aDataPost['data_medicao_esquerda']])
            ->orWhere(['EnderecoMedicoes.data_medicao' => $aDataPost['data_medicao_direita']])
            ->toArray();

        $aData = self::getArrayFormated($oDataTotal, $aDataPost);

        return $oResponse
            ->setStatus(200)
            ->setDataExtra($aData);
    }

    private static function getPercentuais($aDataEsquerda, $aDataDireita)
    {
        $iPorcentagemAreaM2   = ($aDataDireita['area_m2'] - $aDataEsquerda['area_m2']) / $aDataEsquerda['area_m2'] * 100;
        $iPorcentagemVolumeM3 = ($aDataDireita['volume_m3'] - $aDataEsquerda['volume_m3']) / $aDataEsquerda['volume_m3'] * 100;

        return [
            'porcentagem_area_m2'   => number_format($iPorcentagemAreaM2, 2, '.', ''),
            'porcentagem_volume_m3' => number_format($iPorcentagemVolumeM3, 2, '.', '')
        ];
    }

    private static function checkRegistroDatas($aDataPost)
    {
        $oResponse = new ResponseUtil();

        $oDataEsquerda = LgDbUtil::getFind('EnderecoMedicaoDados')
            ->contain('EnderecoMedicoes')
            ->where(['EnderecoMedicoes.data_medicao' => $aDataPost['data_medicao_esquerda']])
            ->toArray();

        if (!$oDataEsquerda)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Não existem registros para a data ' . $aDataPost['data_medicao_esquerda']);

        $oDataEsquerda = LgDbUtil::getFind('EnderecoMedicaoDados')
            ->contain('EnderecoMedicoes')
            ->where(['EnderecoMedicoes.data_medicao' => $aDataPost['data_medicao_direita']])
            ->toArray();
            
        if (!$oDataEsquerda)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Não existem registros para a data ' . $aDataPost['data_medicao_direita']);

        return $oResponse
            ->setStatus(200);
    }

    private static function getArrayFormated($oDataTotal, $aDataPost)
    {
        $aData = [];
        foreach ($oDataTotal as $oData) {
            
            $aData[$oData->endereco_id][$oData->endereco_medicao->data_medicao->format('Y-m-d')] = [
                'area_m2'   => $oData->area_m2,
                'volume_m3' => $oData->volume_m3
            ];

        }

        foreach ($aData as $key => $aValue) {

            $aPercentuais = self::getPercentuais($aValue[$aDataPost['data_medicao_esquerda']], $aValue[$aDataPost['data_medicao_direita']]);

            $aData[$key][$aDataPost['data_medicao_direita']] = $aPercentuais;

        }

        return $aData;
    }
}
