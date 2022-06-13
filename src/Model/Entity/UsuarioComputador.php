<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UsuarioComputador Entity
 *
 * @property int $id
 * @property int $computador_id
 * @property int $usuario_id
 *
 * @property \App\Model\Entity\Computador $computador
 * @property \App\Model\Entity\Usuario $usuario
 */
class UsuarioComputador extends Entity
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
        
        'computador_id' => true,
        'usuario_id' => true,
        'computador' => true,
        'usuario' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
