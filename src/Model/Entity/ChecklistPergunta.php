<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ChecklistPergunta Entity
 *
 * @property int $id
 * @property string $descricao
 * @property int $ordem
 * @property int $checklist_id
 * @property string|null $observacao
 * @property int|null $permite_multiplas
 * @property int|null $obrigatorio
 *
 * @property \App\Model\Entity\Checklist $checklist
 * @property \App\Model\Entity\ChecklistPerguntaResposta[] $checklist_pergunta_respostas
 * @property \App\Model\Entity\ChecklistResvPergunta[] $checklist_resv_perguntas
 */
class ChecklistPergunta extends Entity
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
        'ordem' => true,
        'checklist_id' => true,
        'observacao' => true,
        'permite_multiplas' => true,
        'obrigatorio' => true,
        'checklist' => true,
        'checklist_pergunta_respostas' => true,
        'checklist_resv_perguntas' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
