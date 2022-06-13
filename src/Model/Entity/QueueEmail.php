<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * QueueEmail Entity
 *
 * @property int $id
 * @property int|null $email_id
 * @property string|null $from_name
 * @property string|null $from_email
 * @property string|null $to_email
 * @property string|null $subject
 * @property string $max_attempts
 * @property int $attempts
 * @property int $success
 * @property \Cake\I18n\Time|null $date_published
 * @property \Cake\I18n\Time|null $last_attempt
 * @property \Cake\I18n\Time|null $date_sent
 * @property int|null $user_id
 * @property string|null $profile
 * @property string|null $attachs
 * @property string $html
 *
 * @property \App\Model\Entity\Email $email
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\QueueEmailAnexo[] $queue_email_anexos
 */
class QueueEmail extends Entity
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
        'from_name' => true,
        'from_email' => true,
        'to_email' => true,
        'subject' => true,
        'max_attempts' => true,
        'attempts' => true,
        'success' => true,
        'date_published' => true,
        'last_attempt' => true,
        'date_sent' => true,
        'user_id' => true,
        'profile' => true,
        'attachs' => true,
        'html' => true,
        'email' => true,
        'user' => true,
        'queue_email_anexos' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
