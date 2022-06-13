<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ControleAcessoCodigo Entity
 *
 * @property int $id
 * @property int $tipo_acesso_id
 * @property string $codigo
 * @property int $credenciamento_pessoa_id
 * @property int $controle_acesso_solicitacao_leitura_id
 *
 * @property \App\Model\Entity\TipoAcesso $tipo_acesso
 * @property \App\Model\Entity\CredenciamentoPessoa $credenciamento_pessoa
 * @property \App\Model\Entity\ControleAcessoSolicitacaoLeitura $controle_acesso_solicitacao_leitura
 */
class ControleAcessoCodigo extends Entity
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
        
        'tipo_acesso_id' => true,
        'codigo' => true,
        'credenciamento_pessoa_id' => true,
        'controle_acesso_solicitacao_leitura_id' => true,
        'tipo_acesso' => true,
        'credenciamento_pessoa' => true,
        'controle_acesso_solicitacao_leitura' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
