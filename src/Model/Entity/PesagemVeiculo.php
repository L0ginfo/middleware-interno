<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ObjectUtil;
use App\Util\ResponseUtil;
use App\Util\SessionUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * PesagemVeiculo Entity
 *
 * @property int $id
 * @property float|null $peso
 * @property int|null $cavalo
 * @property int|null $manual
 * @property string|null $balanca_codigo
 * @property string|null $balanca_id
 * @property int $veiculo_id
 * @property int $pesagem_tipo_id
 * @property int $pesagem_id
 *
 * @property \App\Model\Entity\Balanca $balanca
 * @property \App\Model\Entity\Veiculo $veiculo
 * @property \App\Model\Entity\PesagemTipo $pesagem_tipo
 * @property \App\Model\Entity\Pesagem $pesagem
 */
class PesagemVeiculo extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
     /* Default fields
        
        'peso' => true,
        'cavalo' => true,
        'manual' => true,
        'balanca_codigo' => true,
        'balanca_id' => true,
        'veiculo_id' => true,
        'pesagem_tipo_id' => true,
        'pesagem_id' => true,
        'balanca' => true,
        'veiculo' => true,
        'pesagem_tipo' => true,
        'pesagem' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getOrSave($aData)
    {
        $oPesagemVeiculo = TableRegistry::getTableLocator()->get('PesagemVeiculos')->find()
            ->where($aData)
            ->first();
            
        if (!$oPesagemVeiculo)
            $oPesagemVeiculo = TableRegistry::getTableLocator()->get('PesagemVeiculos')->save(
                    TableRegistry::getTableLocator()->get('PesagemVeiculos')->newEntity($aData)
            );

        return $oPesagemVeiculo;
    }

    public static function saveLog($oResponse, $oResv, $uEnderecoID, $sOperacao)
    {
        if ($oResponse->getStatus() == 200)
            return;

        try {
            $oReportResponse = LgDbUtil::saveNew('ReportResponses', [
                'tabela_referente'         => 'Resvs',
                'operacao_referente'       => $sOperacao,
                'usuario_conectado_id'     => SessionUtil::getUsuarioConectado(),
                'id_coluna'                => $oResv->id,
                'response_util_obj'        => ObjectUtil::getAsJson($oResponse),
                'response_util_text'       => strip_tags(str_replace(
                    ['<br>'],
                    ["\n\r"],
                    $oResponse->getMessage()
                )),
                'response_util_title'      => $oResponse->getTitle(),
                'response_util_status'     => $oResponse->getStatus(),
                'response_util_data_extra' => ObjectUtil::getAsJson($oResponse->getDataExtra()),
            ]);
        } catch (\Throwable $th) { }
        
    }

    public static function saveLogValidate($oResv, $sValidateObject, $bAcceptedValidate, $sOperacao)
    {
        try {
            $oResponse = json_decode($sValidateObject);

            if (!$oResponse || $oResponse->message == 'OK')
                return;

            $oReportResponse = LgDbUtil::saveNew('ReportResponses', [
                'tabela_referente'         => 'Resvs',
                'operacao_referente'       => $sOperacao,
                'usuario_conectado_id'     => SessionUtil::getUsuarioConectado(),
                'id_coluna'                => $oResv->id,
                'response_util_obj'        => $sValidateObject,
                'response_util_text'       => strip_tags(str_replace(
                    ['<br>'],
                    ["\n\r"],
                    $oResponse->message
                )),
                'response_util_title'      => $oResponse->title,
                'response_util_status'     => $oResponse->status,
                'response_util_data_extra' => $bAcceptedValidate != 'false' ? 'Aceitou a Validação' : 'Não aceitou',
            ], true);
        } catch (\Throwable $th) { }
    }
}
