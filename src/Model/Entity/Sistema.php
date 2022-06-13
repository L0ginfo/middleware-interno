<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Sistema Entity
 *
 * @property int $id
 * @property string $nome
 * @property int $ativo
 * @property string|null $email_assinatura
 * @property string|null $email_padrao
 * @property string|null $email_padrao_TFA
 * @property string|null $sem_registro
 * @property string|null $sistema_email_padrao_transportadora
 * @property \Cake\I18n\Time|null $created_at
 * @property int|null $created_by
 * @property \Cake\I18n\Time|null $updated_at
 * @property int|null $updated_by
 *
 * @property \App\Model\Entity\Perfil[] $perfis
 */
class Sistema extends Entity
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
    protected $_accessible = [
        'nome' => true,
        'ativo' => true,
        'email_assinatura' => true,
        'email_padrao' => true,
        'email_padrao_TFA' => true,
        'sem_registro' => true,
        'sistema_email_padrao_transportadora' => true,
        'created_at' => true,
        'created_by' => true,
        'updated_at' => true,
        'updated_by' => true,
        'perfis' => true
    ];
}
