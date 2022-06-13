<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RfbPerfilEmpresa Entity
 *
 * @property int $id
 * @property int $empresa_id
 * @property int $perfil_id
 *
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\Perfil $perfil
 */
class RfbPerfilEmpresa extends Entity
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
        'perfil_id' => true,
        'empresa' => true,
        'perfil' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
