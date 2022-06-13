<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ControleAcessoSolicitacaoLeitura Entity
 *
 * @property int $id
 * @property int $controle_acesso_controladora_id
 * @property int $credenciamento_pessoa_id
 * @property \Cake\I18n\Time $data_hora
 * @property int $ativo
 * @property int $controle_acesso_equipamento_id
 *
 * @property \App\Model\Entity\ControleAcessoControladora $controle_acesso_controladora
 * @property \App\Model\Entity\CredenciamentoPessoa $credenciamento_pessoa
 * @property \App\Model\Entity\ControleAcessoEquipamento $controle_acesso_equipamento
 * @property \App\Model\Entity\ControleAcessoCodigo[] $controle_acesso_codigos
 */
class ControleAcessoSolicitacaoLeitura extends Entity
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
        
        'controle_acesso_controladora_id' => true,
        'credenciamento_pessoa_id' => true,
        'data_hora' => true,
        'ativo' => true,
        'controle_acesso_equipamento_id' => true,
        'controle_acesso_controladora' => true,
        'credenciamento_pessoa' => true,
        'controle_acesso_equipamento' => true,
        'controle_acesso_codigos' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
