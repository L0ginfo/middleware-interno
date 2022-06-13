<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UsuarioTransportadora Entity
 *
 * @property int $id
 * @property int|null $usuario_id
 * @property int|null $transportadora_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\Usuario $usuario
 * @property \App\Model\Entity\Transportadora $transportadora
 */
class UsuarioTransportadora extends Entity
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
        
        'usuario_id' => true,
        'transportadora_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'usuario' => true,
        'transportadora' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
