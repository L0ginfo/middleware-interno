<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GradeHorarioBloqueioPerfi Entity
 *
 * @property int $id
 * @property int $grade_horario_id
 * @property int $perfil_id
 *
 * @property \App\Model\Entity\GradeHorario $grade_horario
 * @property \App\Model\Entity\Perfil $perfil
 */
class GradeHorarioBloqueioPerfi extends Entity
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
        'perfil_id' => true,
        'grade_horario' => true,
        'perfil' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
