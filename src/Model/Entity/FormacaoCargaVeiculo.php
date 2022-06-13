<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FormacaoCargaVeiculo Entity
 *
 * @property int $id
 * @property int $veiculo_id
 * @property int $formacao_carga_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\Veiculo $veiculo
 * @property \App\Model\Entity\FormacaoCarga $formacao_carga
 */
class FormacaoCargaVeiculo extends Entity
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
        
        'veiculo_id' => true,
        'formacao_carga_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'veiculo' => true,
        'formacao_carga' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
