<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CredenciamentoPessoaArea Entity
 *
 * @property int $id
 * @property int $credenciamento_pessoa_id
 * @property int $controle_acesso_area_id
 *
 * @property \App\Model\Entity\CredenciamentoPessoa $credenciamento_pessoa
 * @property \App\Model\Entity\ControleAcessoArea $controle_acesso_area
 */
class CredenciamentoPessoaArea extends Entity
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
        
        'credenciamento_pessoa_id' => true,
        'controle_acesso_area_id' => true,
        'credenciamento_pessoa' => true,
        'controle_acesso_area' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
