<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LoteSolicitacao Entity.
 *
 * @property int $id
 * @property string $lote
 * @property string $descricao
 * @property string $comentario
 * @property \Cake\I18n\Time $data_solicitacao
 * @property int $tipo_servico_id
 * @property \App\Model\Entity\LoteServico[] $lote_servicos
 */
class LoteSolicitacao extends Entity
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
