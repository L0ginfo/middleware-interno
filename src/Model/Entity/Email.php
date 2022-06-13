<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Email Entity
 *
 * @property int $id
 * @property string $para
 * @property string $assunto
 * @property string|null $codigo
 * @property string|null $header
 * @property string|null $body
 * @property string|null $footer
 * @property int $smtp_id
 * @property int $tipo_email_id
 * @property int|null $usuario_id
 *
 * @property \App\Model\Entity\Smtp $smtp
 * @property \App\Model\Entity\TipoEmail $tipo_email
 * @property \App\Model\Entity\Usuario $usuario
 * @property \App\Model\Entity\EmailAnexo[] $email_anexos
 * @property \App\Model\Entity\QueueEmail[] $queue_emails
 */
class Email extends Entity
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
        
        'para' => true,
        'assunto' => true,
        'codigo' => true,
        'header' => true,
        'body' => true,
        'footer' => true,
        'smtp_id' => true,
        'tipo_email_id' => true,
        'usuario_id' => true,
        'smtp' => true,
        'tipo_email' => true,
        'usuario' => true,
        'email_anexos' => true,
        'queue_emails' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
