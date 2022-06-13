<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NotaFiscal Entity
 *
 * @property int $id
 * @property string $numero
 * @property int $nota_fiscal_tipo_id
 *
 * @property \App\Model\Entity\NotaFiscalTipo $nota_fiscal_tipo
 * @property \App\Model\Entity\NotaFiscalCfop[] $nota_fiscal_cfops
 * @property \App\Model\Entity\ResvNota[] $resv_notas
 */
class NotaFiscal extends Entity
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
        'nota_fiscal_tipo_id' => true,
        'nota_fiscal_tipo' => true,
        'nota_fiscal_cfops' => true,
        'resv_notas' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
