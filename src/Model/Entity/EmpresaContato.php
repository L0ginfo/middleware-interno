<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmpresaContato Entity
 *
 * @property int $id
 * @property int|null $contato_id
 * @property int|null $empresa_id
 *
 * @property \App\Model\Entity\Contato $contato
 * @property \App\Model\Entity\Empresa $empresa
 */
class EmpresaContato extends Entity
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
        
        'contato_id' => true,
        'empresa_id' => true,
        'contato' => true,
        'empresa' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
