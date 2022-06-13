<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UsuarioVeiculo Entity
 *
 * @property int $id
 * @property int $veiculo_id
 * @property int $usuario_id
 *
 * @property \App\Model\Entity\Veiculo $veiculo
 * @property \App\Model\Entity\Usuario $usuario
 */
class UsuarioVeiculo extends Entity
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
        
        'veiculo_id' => true,
        'usuario_id' => true,
        'veiculo' => true,
        'usuario' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
