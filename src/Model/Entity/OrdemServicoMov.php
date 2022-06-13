<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrdemServicoMov Entity
 *
 * @property int $id
 * @property int|null $ordem_servico_id
 * @property int|null $movimentacao_estoque_id
 *
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 * @property \App\Model\Entity\MovimentacaoEstoque $movimentacao_estoque
 */
class OrdemServicoMov extends Entity
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
        
        'ordem_servico_id' => true,
        'movimentacao_estoque_id' => true,
        'ordem_servico' => true,
        'movimentacao_estoque' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
