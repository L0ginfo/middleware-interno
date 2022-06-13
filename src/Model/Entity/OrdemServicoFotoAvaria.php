<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrdemServicoFotoAvaria Entity
 *
 * @property int $id
 * @property int|null $ordem_servico_id
 * @property int|null $anexo_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 * @property \App\Model\Entity\Anexo $anexo
 */
class OrdemServicoFotoAvaria extends Entity
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
        
        'ordem_servico_id' => true,
        'anexo_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'ordem_servico' => true,
        'anexo' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
