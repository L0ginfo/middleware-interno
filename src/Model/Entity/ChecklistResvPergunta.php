<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ChecklistResvPergunta Entity
 *
 * @property int $id
 * @property int $checklist_resv_id
 * @property int $checklist_pergunta_id
 * @property string|null $observacoes
 *
 * @property \App\Model\Entity\ChecklistResv $checklist_resv
 * @property \App\Model\Entity\ChecklistPergunta $checklist_pergunta
 * @property \App\Model\Entity\ChecklistResvResposta[] $checklist_resv_respostas
 */
class ChecklistResvPergunta extends Entity
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
        
        'checklist_resv_id' => true,
        'checklist_pergunta_id' => true,
        'observacoes' => true,
        'checklist_resv' => true,
        'checklist_pergunta' => true,
        'checklist_resv_respostas' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
