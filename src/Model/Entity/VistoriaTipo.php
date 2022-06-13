<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VistoriaTipo Entity
 *
 * @property int $id
 * @property string $descricao
 *
 * @property \App\Model\Entity\GradeHorario[] $grade_horarios
 * @property \App\Model\Entity\Vistoria[] $vistorias
 */
class VistoriaTipo extends Entity
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
        'grade_horarios' => true,
        'vistorias' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
