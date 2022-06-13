<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LoteServico Entity.
 *
 * @property int $id
 * @property string $lote
 * @property \Cake\I18n\Time $created
 * @property int $tipo_servico_id
 * @property \App\Model\Entity\TipoServico $tipo_servico
 * @property int $created_by
 * @property string $iso
 * @property int $tipo_iso
 * @property string $container
 * @property string $tipo_container
 * @property string $cesv
 * @property string $placa
 * @property \Cake\I18n\Time $data_entrada
 * @property int $tipo_servico_status_id
 * @property \App\Model\Entity\TipoServicoStatus $tipo_servico_status
 * @property string $os_sara
 * @property string $motorista_cpf
 * @property string $motorista_nome
 * @property string $transportadora_nome
 * @property string $transportadora_cnpj
 * @property \Cake\I18n\Time $data_avaliacao
 * @property int $lote_solicitacao_id
 * @property \App\Model\Entity\LoteSolicitacao $lote_solicitacao
 */
class LoteServico extends Entity
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
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
