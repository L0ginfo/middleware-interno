<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TokenUtilizado Entity
 *
 * @property int $id
 * @property string|null $token
 * @property int|null $usuario_id
 * @property int|null $resv_id
 * @property int|null $valido
 * @property \Cake\I18n\Time|null $created_at
 *
 * @property \App\Model\Entity\Usuario $usuario
 * @property \App\Model\Entity\Resv $resv
 */
class TokenUtilizado extends Entity
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
        
        'token' => true,
        'usuario_id' => true,
        'resv_id' => true,
        'valido' => true,
        'created_at' => true,
        'usuario' => true,
        'resv' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'token',
    ];
}
