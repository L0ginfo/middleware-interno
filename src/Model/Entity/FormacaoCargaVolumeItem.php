<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FormacaoCargaVolumeItem Entity
 *
 * @property int $id
 * @property int $ordem_servico_item_separacao_id
 * @property int $formacao_carga_volume_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 * @property float $quantidade
 *
 * @property \App\Model\Entity\OrdemServicoItemSeparacao $ordem_servico_item_separacao
 * @property \App\Model\Entity\FormacaoCargaVolume $formacao_carga_volume
 */
class FormacaoCargaVolumeItem extends Entity
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
        
        'ordem_servico_item_separacao_id' => true,
        'formacao_carga_volume_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'quantidade' => true,
        'ordem_servico_item_separacao' => true,
        'formacao_carga_volume' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
