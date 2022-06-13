<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PlanejamentoMaritimoTernoEquipamento Entity
 *
 * @property int $id
 * @property int $planejamento_maritimo_terno_id
 * @property int $equipamento_id
 *
 * @property \App\Model\Entity\PlanejamentoMaritimoTerno $planejamento_maritimo_terno
 * @property \App\Model\Entity\Equipamento $equipamento
 */
class PlanejamentoMaritimoTernoEquipamento extends Entity
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
        
        'planejamento_maritimo_terno_id' => true,
        'equipamento_id' => true,
        'planejamento_maritimo_terno' => true,
        'equipamento' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
