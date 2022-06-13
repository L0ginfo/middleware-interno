<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UsuarioBalanca Entity
 *
 * @property int $id
 * @property string|null $descricao
 * @property int $usuario_id
 * @property string $balanca_codigo
 *
 * @property \App\Model\Entity\Usuario $usuario
 */
class UsuarioBalanca extends Entity
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
        
        'descricao' => true,
        'usuario_id' => true,
        'balanca_codigo' => true,
        'usuario' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
