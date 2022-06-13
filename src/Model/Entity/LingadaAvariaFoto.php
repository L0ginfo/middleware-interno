<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LingadaAvariaFoto Entity
 *
 * @property int $id
 * @property string $name
 * @property int $lingada_avaria_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\LingadaAvaria $lingada_avaria
 */
class LingadaAvariaFoto extends Entity
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
        
        'name' => true,
        'lingada_avaria_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'lingada_avaria' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
