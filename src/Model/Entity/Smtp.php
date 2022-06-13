<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Smtp Entity
 *
 * @property int $id
 * @property string $host
 * @property int $port
 * @property string $user
 * @property string $pass
 * @property int $auth
 * @property string $smtp_secure
 *
 * @property \App\Model\Entity\Email[] $emails
 */
class Smtp extends Entity
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
        
        'host' => true,
        'port' => true,
        'user' => true,
        'pass' => true,
        'auth' => true,
        'smtp_secure' => true,
        'emails' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
