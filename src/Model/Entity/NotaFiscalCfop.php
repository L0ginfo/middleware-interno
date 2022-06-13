<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NotaFiscalCfop Entity
 *
 * @property int $id
 * @property string $numero
 * @property int $nota_fiscal_id
 *
 * @property \App\Model\Entity\NotaFiscal $nota_fiscal
 */
class NotaFiscalCfop extends Entity
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
        
        'numero' => true,
        'nota_fiscal_id' => true,
        'nota_fiscal' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
