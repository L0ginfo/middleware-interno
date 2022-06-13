<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ControleAcessoArea Entity
 *
 * @property int $id
 * @property string $descricao
 * @property int $situacao
 * @property string|null $motivo_situacao
 * @property int $is_alfandegado
 * @property int $nivel_id
 * @property int $tipo_area_id
 *
 * @property \App\Model\Entity\ControleAcessoNivei $controle_acesso_nivei
 * @property \App\Model\Entity\ControleAcessoTipoArea $controle_acesso_tipo_area
 * @property \App\Model\Entity\CredenciamentoPessoaArea[] $credenciamento_pessoa_areas
 */
class ControleAcessoArea extends Entity
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
        'situacao' => true,
        'motivo_situacao' => true,
        'is_alfandegado' => true,
        'nivel_id' => true,
        'tipo_area_id' => true,
        'controle_acesso_nivei' => true,
        'controle_acesso_tipo_area' => true,
        'credenciamento_pessoa_areas' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
