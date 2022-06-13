<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CancelaAcaoPermitida Entity
 *
 * @property int $id
 * @property int $cancela_id
 * @property int $cancela_acao_id
 *
 * @property \App\Model\Entity\Cancela $cancela
 * @property \App\Model\Entity\CancelaAcao $cancela_acao
 */
class CancelaAcaoPermitida extends Entity
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
        
        'cancela_id' => true,
        'cancela_acao_id' => true,
        'cancela' => true,
        'cancela_acao' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
