<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FilaIntegracaoFaturamentoBaixa Entity
 *
 * @property int $id
 * @property int $faturamento_baixa_id
 * @property int $faturamento_id
 * @property int|null $faturamento_armazenagem_id
 * @property string|null $json_wms_enviado
 * @property string|null $json_callback_recebido
 * @property string|null $integracao_codigo
 * @property string|null $response_util_title
 * @property string|null $response_util_message
 * @property string|null $response_util_status
 * @property int|null $status_integracao_id
 * @property \Cake\I18n\Time|null $created_at
 * @property \Cake\I18n\Time|null $modified_at
 *
 * @property \App\Model\Entity\FaturamentoBaixa $faturamento_baixa
 * @property \App\Model\Entity\Faturamento $faturamento
 * @property \App\Model\Entity\FaturamentoArmazenagem $faturamento_armazenagem
 * @property \App\Model\Entity\StatusIntegracao $status_integracao
 */
class FilaIntegracaoFaturamentoBaixa extends Entity
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
        
        'faturamento_baixa_id' => true,
        'faturamento_id' => true,
        'faturamento_armazenagem_id' => true,
        'json_wms_enviado' => true,
        'json_callback_recebido' => true,
        'integracao_codigo' => true,
        'response_util_title' => true,
        'response_util_message' => true,
        'response_util_status' => true,
        'status_integracao_id' => true,
        'created_at' => true,
        'modified_at' => true,
        'faturamento_baixa' => true,
        'faturamento' => true,
        'faturamento_armazenagem' => true,
        'status_integracao' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
