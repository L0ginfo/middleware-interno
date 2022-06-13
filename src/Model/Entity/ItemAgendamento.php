<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ItemAgendamento Entity.
 *
 * @property int $id
 * @property int $agendamento_id
 * @property \App\Model\Entity\Agendamento $agendamento
 * @property int $quantidade
 * @property int $entrada_id
 * @property int $item_id
 * @property \App\Model\Entity\Item $item
 * @property int $container_id
 * @property \App\Model\Entity\Container $container
 */
class ItemAgendamento extends Entity
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
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
