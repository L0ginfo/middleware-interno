<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ResvMaritima Entity
 *
 * @property int $id
 * @property int|null $navio_id
 * @property int|null $resv_id
 *
 * @property \App\Model\Entity\Veiculo $veiculo
 * @property \App\Model\Entity\Resv $resv
 */
class ResvMaritima extends Entity
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
        
        'navio_id' => true,
        'resv_id' => true,
        'veiculo' => true,
        'resv' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
