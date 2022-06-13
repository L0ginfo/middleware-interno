<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EventoParametro Entity
 *
 * @property int $id
 * @property string $descricao
 * @property int $operador_id
 *
 * @property \App\Model\Entity\Operador $operador
 * @property \App\Model\Entity\Evento[] $eventos
 */
class EventoParametro extends Entity
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
        'operador_id' => true,
        'operador' => true,
        'eventos' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
