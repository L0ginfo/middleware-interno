<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmpresasRetencao Entity
 *
 * @property int $id
 * @property int|null $empresa_id
 * @property int|null $retencao_id
 * @property float|null $valor
 *
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\Retencao $retencao
 */
class EmpresasRetencao extends Entity
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
        
        'empresa_id' => true,
        'retencao_id' => true,
        'valor' => true,
        'empresa' => true,
        'retencao' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
