<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NotaFiscalConhecimento Entity
 *
 * @property int $id
 * @property int $nota_fiscal_id
 * @property string|null $numero_documento
 * @property string|null $cnpj_cliente
 *
 * @property \App\Model\Entity\NotaFiscal $nota_fiscal
 */
class NotaFiscalConhecimento extends Entity
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
        'numero_documento' => true,
        'cnpj_cliente' => true,
        'nota_fiscal' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
