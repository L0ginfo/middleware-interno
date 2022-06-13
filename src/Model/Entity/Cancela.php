<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cancela Entity
 *
 * @property int $id
 * @property string $descricao
 * @property string|null $codigo
 * @property int $cancela_id
 * @property int $balanca_id
 *
 * @property \App\Model\Entity\Cancela[] $cancelas
 * @property \App\Model\Entity\Balanca $balanca
 * @property \App\Model\Entity\CancelaAcaoPermitida[] $cancela_acao_permitidas
 */
class Cancela extends Entity
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
        'codigo' => true,
        'cancela_id' => true,
        'balanca_id' => true,
        'cancelas' => true,
        'balanca' => true,
        'cancela_acao_permitidas' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
