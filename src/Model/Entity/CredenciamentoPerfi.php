<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CredenciamentoPerfi Entity
 *
 * @property int $id
 * @property int $perfil_id
 * @property int|null $validade_dias
 * @property int $situacao
 * @property string|null $motivo_situacao
 * @property int|null $tipo_acesso_id
 *
 * @property \App\Model\Entity\Perfil $perfil
 * @property \App\Model\Entity\TipoAcesso $tipo_acesso
 * @property \App\Model\Entity\CredenciamentoPessoa[] $credenciamento_pessoas
 */
class CredenciamentoPerfi extends Entity
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
        
        'perfil_id' => true,
        'validade_dias' => true,
        'situacao' => true,
        'motivo_situacao' => true,
        'tipo_acesso_id' => true,
        'perfil' => true,
        'tipo_acesso' => true,
        'credenciamento_pessoas' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
