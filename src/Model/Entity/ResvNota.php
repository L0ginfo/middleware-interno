<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ResvNota Entity
 *
 * @property int $id
 * @property int $nota_fiscal_id
 * @property int $resv_id
 *
 * @property \App\Model\Entity\NotaFiscal $nota_fiscal
 * @property \App\Model\Entity\Resv $resv
 */
class ResvNota extends Entity
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
        
        'nota_fiscal_id' => true,
        'resv_id' => true,
        'nota_fiscal' => true,
        'resv' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
