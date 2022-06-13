<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CredenciamentoPessoaAnexo Entity
 *
 * @property int $id
 * @property int $anexo_id
 * @property int $credenciamento_pessoa_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\Anexo $anexo
 * @property \App\Model\Entity\CredenciamentoPessoa $credenciamento_pessoa
 */
class CredenciamentoPessoaAnexo extends Entity
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
        
        'anexo_id' => true,
        'credenciamento_pessoa_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'anexo' => true,
        'credenciamento_pessoa' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
