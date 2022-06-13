<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;
use Cake\Utility\Inflector;

/**
 * Computador Entity
 *
 * @property int $id
 * @property string|null $hostname
 * @property string|null $uuid
 *
 * @property \App\Model\Entity\UsuarioComputador[] $usuario_computadores
 */
class Computador extends Entity
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
        
        'hostname' => true,
        'uuid' => true,
        'usuario_computadores' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
