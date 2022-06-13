<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * HorarioDeRecurso Entity.
 *
 * @property int $id
 * @property string $nome
 * @property int $recurso_id
 * @property \App\Model\Entity\Recurso $recurso
 * @property string $hora_inicio
 * @property string $hora_fim
 * @property \Cake\I18n\Time $data_inicio
 * @property \Cake\I18n\Time $data_fim
 * @property int $tempo_limite
 */
class HorarioDeRecurso extends Entity
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
