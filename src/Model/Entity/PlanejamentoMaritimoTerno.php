<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PlanejamentoMaritimoTerno Entity
 *
 * @property int $id
 * @property int $planejamento_maritimo_id
 * @property int $terno_id
 *
 * @property \App\Model\Entity\PlanejamentoMaritimo $planejamento_maritimo
 * @property \App\Model\Entity\Terno $terno
 * @property \App\Model\Entity\PlanejamentoMaritimoTernoPeriodo[] $planejamento_maritimo_terno_periodos
 * @property \App\Model\Entity\PlanejamentoMaritimoTernoUsuario[] $planejamento_maritimo_terno_usuarios
 */
class PlanejamentoMaritimoTerno extends Entity
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
        
        'planejamento_maritimo_id' => true,
        'terno_id' => true,
        'planejamento_maritimo' => true,
        'terno' => true,
        'planejamento_maritimo_terno_periodos' => true,
        'planejamento_maritimo_terno_usuarios' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
