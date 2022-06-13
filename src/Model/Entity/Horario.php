<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Horario Entity.
 *
 * @property int $id
 * @property string $Nome
 * @property int $operacao_id
 * @property \App\Model\Entity\Operacao $operacao
 * @property int $quantidade_maxima
 * @property \Cake\I18n\Time $hora_inicio
 * @property \Cake\I18n\Time $hora_fim
 * @property bool $segunda
 * @property bool $terca
 * @property bool $quarta
 * @property bool $quinta
 * @property bool $sexta
 * @property bool $sabado
 * @property bool $domingo
 */
class Horario extends Entity {

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
