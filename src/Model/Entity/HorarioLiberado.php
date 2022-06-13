<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * HorarioLiberado Entity.
 *
 * @property int $id
 * @property int $horario_id
 * @property \App\Model\Entity\Horario $horario
 * @property \Cake\I18n\Time $hora
 * @property \Cake\I18n\Time $data
 * @property string $cnpj
 */
class HorarioLiberado extends Entity
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
