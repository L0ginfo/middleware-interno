<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PlanejamentoMaritimoTernoPeriodo Entity
 *
 * @property int $id
 * @property int $planejamento_maritimo_terno_id
 * @property int $periodo_id
 *
 * @property \App\Model\Entity\PlanejamentoMaritimoTerno $planejamento_maritimo_terno
 * @property \App\Model\Entity\PortoTrabalhoPeriodo $porto_trabalho_periodo
 */
class PlanejamentoMaritimoTernoPeriodo extends Entity
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
        'periodo_id' => true,
        'planejamento_maritimo_terno' => true,
        'porto_trabalho_periodo' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
