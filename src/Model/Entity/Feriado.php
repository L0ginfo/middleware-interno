<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Feriado Entity
 *
 * @property int $id
 * @property \Cake\I18n\Date $date
 * @property string $motivo_feriado
 */
class Feriado extends Entity
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
        'date' => true,
        'motivo_feriado' => true
    ];
}
