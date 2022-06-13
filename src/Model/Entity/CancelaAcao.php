<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CancelaAcao Entity
 *
 * @property int $id
 * @property string $descricao
 *
 * @property \App\Model\Entity\CancelaAcaoPermitida[] $cancela_acao_permitidas
 */
class CancelaAcao extends Entity
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
        'cancela_acao_permitidas' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
