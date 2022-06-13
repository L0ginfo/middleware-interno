<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SolicitacaoLeituraOcr Entity
 *
 * @property int $id
 * @property int|null $balanca_id
 * @property int|null $ativo
 * @property string|null $fluxo
 * @property string|null $tipo_fluxo
 * @property string|null $tipo_entrada
 *
 * @property \App\Model\Entity\Balanca $balanca
 */
class SolicitacaoLeituraOcr extends Entity
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
        
        'balanca_id' => true,
        'ativo' => true,
        'fluxo' => true,
        'tipo_fluxo' => true,
        'tipo_entrada' => true,
        'balanca' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
