<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ResvPlanejamentoMaritimo Entity
 *
 * @property int $id
 * @property int $resv_id
 * @property int $planejamento_maritimo_id
 *
 * @property \App\Model\Entity\Resv $resv
 * @property \App\Model\Entity\PlanejamentoMaritimo $planejamento_maritimo
 */
class ResvPlanejamentoMaritimo extends Entity
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
        
        'resv_id' => true,
        'planejamento_maritimo_id' => true,
        'resv' => true,
        'planejamento_maritimo' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
