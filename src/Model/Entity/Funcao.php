<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Funcao Entity
 *
 * @property int $id
 * @property string $descricao
 *
 * @property \App\Model\Entity\OrdemServicoConferente[] $ordem_servico_conferentes
 * @property \App\Model\Entity\PlanejamentoMaritimoTernoUsuario[] $planejamento_maritimo_terno_usuarios
 */
class Funcao extends Entity
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
        'ordem_servico_conferentes' => true,
        'planejamento_maritimo_terno_usuarios' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
