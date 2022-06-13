<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProgramacaoHistoricoSituacao Entity
 *
 * @property int $id
 * @property int $programacao_id
 * @property int $programacao_situacao_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\Programacao $programacao
 * @property \App\Model\Entity\ProgramacaoSituacao $programacao_situacao
 */
class ProgramacaoHistoricoSituacao extends Entity
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
        
        'programacao_id' => true,
        'programacao_situacao_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'programacao' => true,
        'programacao_situacao' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
