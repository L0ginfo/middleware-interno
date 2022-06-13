<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PlanejamentoMaritimoEventoMudanca Entity
 *
 * @property int $id
 * @property int|null $evento_id
 * @property int|null $planejamento_maritimo_id
 * @property int|null $planejamento_maritimo_mudanca_id
 * @property \Cake\I18n\Time $data_hora
 *
 * @property \App\Model\Entity\Evento $evento
 * @property \App\Model\Entity\PlanejamentoMaritimo $planejamento_maritimo
 * @property \App\Model\Entity\PlanejamentoMaritimoMudanca $planejamento_maritimo_mudanca
 */
class PlanejamentoMaritimoEventoMudanca extends Entity
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
        
        'evento_id' => true,
        'planejamento_maritimo_id' => true,
        'planejamento_maritimo_mudanca_id' => true,
        'data_hora' => true,
        'evento' => true,
        'planejamento_maritimo' => true,
        'planejamento_maritimo_mudanca' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
