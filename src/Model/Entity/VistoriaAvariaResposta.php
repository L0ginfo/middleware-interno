<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VistoriaAvariaResposta Entity
 *
 * @property int $id
 * @property int|null $avaria_id
 * @property int|null $avaria_resposta_id
 * @property int|null $vistoria_avaria_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\Avaria $avaria
 * @property \App\Model\Entity\AvariaResposta $avaria_resposta
 * @property \App\Model\Entity\VistoriaAvaria $vistoria_avaria
 */
class VistoriaAvariaResposta extends Entity
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
        
        'avaria_id' => true,
        'avaria_resposta_id' => true,
        'vistoria_avaria_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'avaria' => true,
        'avaria_resposta' => true,
        'vistoria_avaria' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
