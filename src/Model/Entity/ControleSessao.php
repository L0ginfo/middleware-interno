<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * ControleSessao Entity
 *
 * @property int $id
 * @property string|resource|null $data
 * @property int|null $expires
 * @property \Cake\I18n\Time|null $created_at
 * @property \Cake\I18n\Time|null $modified_at
 */
class ControleSessao extends Entity
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
        
        'data' => true,
        'expires' => true,
        'created_at' => true,
        'modified_at' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
