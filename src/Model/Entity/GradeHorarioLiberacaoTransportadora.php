<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GradeHorarioLiberacaoTransportadora Entity
 *
 * @property int $id
 * @property int $grade_horario_id
 * @property int $transportadora_id
 * @property \Cake\I18n\Time $inicio
 * @property \Cake\I18n\Time $fim
 * @property float|null $cadastrado
 * @property float|null $realizado
 * @property float|null $estimado
 * @property float|null $saldo
 *
 * @property \App\Model\Entity\Transportadora $transportadora
 */
class GradeHorarioLiberacaoTransportadora extends Entity
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
        
        'grade_horario_id' => true,
        'transportadora_id' => true,
        'inicio' => true,
        'fim' => true,
        'cadastrado' => true,
        'realizado' => true,
        'estimado' => true,
        'saldo' => true,
        'transportadora' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
