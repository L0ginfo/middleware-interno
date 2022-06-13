<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PortoTrabalhoPeriodo Entity
 *
 * @property int $id
 * @property string|null $descricao
 * @property int $ordem
 * @property \Cake\I18n\Time $hora_inicio
 * @property \Cake\I18n\Time $hora_fim
 */
class PortoTrabalhoPeriodo extends Entity
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
        'ordem' => true,
        'hora_inicio' => true,
        'hora_fim' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
