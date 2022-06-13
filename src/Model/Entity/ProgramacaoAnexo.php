<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProgramacaoAnexo Entity
 *
 * @property int $id
 * @property int $programacao_id
 * @property int $anexo_id
 *
 * @property \App\Model\Entity\Programacao $programacao
 * @property \App\Model\Entity\Anexo $anexo
 */
class ProgramacaoAnexo extends Entity
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
        'anexo_id' => true,
        'programacao' => true,
        'anexo' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
