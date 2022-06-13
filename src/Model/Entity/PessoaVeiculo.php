<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PessoaVeiculo Entity
 *
 * @property int $id
 * @property int $credenciamento_veiculo_id
 * @property int $credenciamento_pessoa_id
 *
 * @property \App\Model\Entity\CredenciamentoVeiculo $credenciamento_veiculo
 * @property \App\Model\Entity\CredenciamentoPessoa $credenciamento_pessoa
 */
class PessoaVeiculo extends Entity
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
        
        'credenciamento_veiculo_id' => true,
        'credenciamento_pessoa_id' => true,
        'credenciamento_veiculo' => true,
        'credenciamento_pessoa' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
