<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * QueueEmailAnexo Entity
 *
 * @property int $id
 * @property int $queue_email_id
 * @property int $anexo_id
 *
 * @property \App\Model\Entity\QueueEmail $queue_email
 * @property \App\Model\Entity\Anexo $anexo
 */
class QueueEmailAnexo extends Entity
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
        
        'queue_email_id' => true,
        'anexo_id' => true,
        'queue_email' => true,
        'anexo' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
