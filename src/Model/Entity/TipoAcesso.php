<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TipoAcesso Entity
 *
 * @property int $id
 * @property string $descricao
 *
 * @property \App\Model\Entity\ControleAcessoCodigo[] $controle_acesso_codigos
 * @property \App\Model\Entity\ControleAcessoLog[] $controle_acesso_logs
 * @property \App\Model\Entity\CredenciamentoPerfi[] $credenciamento_perfis
 */
class TipoAcesso extends Entity
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
        
        'descricao' => true,
        'controle_acesso_codigos' => true,
        'controle_acesso_logs' => true,
        'credenciamento_perfis' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
