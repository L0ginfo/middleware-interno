<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmailAnexo Entity
 *
 * @property int $id
 * @property int $email_id
 * @property int $anexo_id
 *
 * @property \App\Model\Entity\Email $email
 * @property \App\Model\Entity\Anexo $anexo
 */
class EmailAnexo extends Entity
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
        
        'email_id' => true,
        'anexo_id' => true,
        'email' => true,
        'anexo' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
