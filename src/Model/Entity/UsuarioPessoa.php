<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UsuarioPessoa Entity
 *
 * @property int $id
 * @property int $pessoa_id
 * @property int $usuario_id
 *
 * @property \App\Model\Entity\Pessoa $pessoa
 * @property \App\Model\Entity\Usuario $usuario
 */
class UsuarioPessoa extends Entity
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
        
        'pessoa_id' => true,
        'usuario_id' => true,
        'pessoa' => true,
        'usuario' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
