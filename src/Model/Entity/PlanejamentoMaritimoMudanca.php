<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PlanejamentoMaritimoMudanca Entity
 *
 * @property int $id
 * @property int|null $berco_id
 * @property int|null $planejamento_maritimo_id
 * @property float|null $fwd
 * @property float|null $ifo
 *
 * @property \App\Model\Entity\Berco $berco
 * @property \App\Model\Entity\PlanejamentoMaritimo $planejamento_maritimo
 */
class PlanejamentoMaritimoMudanca extends Entity
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
        
        'berco_id' => true,
        'planejamento_maritimo_id' => true,
        'fwd' => true,
        'ifo' => true,
        'berco' => true,
        'planejamento_maritimo' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
