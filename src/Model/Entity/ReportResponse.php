<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ObjectUtil;
use App\Util\SessionUtil;
use Cake\ORM\Entity;

/**
 * ReportResponse Entity
 *
 * @property int $id
 * @property string|null $tabela_referente
 * @property int|null $id_coluna
 * @property string|null $response_util_obj
 * @property string|null $response_util_text
 * @property string|null $response_util_title
 * @property string|null $response_util_status
 * @property string|null $response_util_data_extra
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 */
class ReportResponse extends Entity
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
        
        'tabela_referente' => true,
        'id_coluna' => true,
        'response_util_obj' => true,
        'response_util_text' => true,
        'response_util_title' => true,
        'response_util_status' => true,
        'response_util_data_extra' => true,
        'created_at' => true,
        'updated_at' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function saveLogResponse($oResponse, $iColunaID, $sOperacao, $sTabelaReferente, $bSalvaMesmoComSucesso = false)
    {
        if ($oResponse->getStatus() == 200 && !$bSalvaMesmoComSucesso)
            return;

        try {
            $oReportResponse = LgDbUtil::saveNew('ReportResponses', [
                'tabela_referente'         => $sTabelaReferente,
                'operacao_referente'       => $sOperacao,
                'usuario_conectado_id'     => SessionUtil::getUsuarioConectado(),
                'id_coluna'                => $iColunaID,
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
}
