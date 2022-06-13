<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PlanejamentoMaritimoTernoUsuario Entity
 *
 * @property int $id
 * @property int $planejamento_maritimo_terno_id
 * @property int $usuario_id
 * @property int $funcao_id
 *
 * @property \App\Model\Entity\PlanejamentoMaritimoTerno $planejamento_maritimo_terno
 * @property \App\Model\Entity\Usuario $usuario
 * @property \App\Model\Entity\PortoTrabalhoFuncao $porto_trabalho_funcao
 */
class PlanejamentoMaritimoTernoUsuario extends Entity
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
        
        'planejamento_maritimo_terno_id' => true,
        'usuario_id' => true,
        'funcao_id' => true,
        'planejamento_maritimo_terno' => true,
        'usuario' => true,
        'porto_trabalho_funcao' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public function getNome(){
        return @$this->usuario->nome;
    }

    public function getMatricula(){
        return @$this->usuario->codigo;
    }

    public function getFuncao(){
        return @$this->porto_trabalho_funcao->descricao;
    }
}
