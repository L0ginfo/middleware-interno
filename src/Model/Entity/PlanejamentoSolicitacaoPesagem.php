<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PlanejamentoSolicitacaoPesagem Entity
 *
 * @property int $id
 * @property int|null $planejamento_movimentacao_produto_id
 * @property \Cake\I18n\Time|null $data_hora_solicitacao
 *
 * @property \App\Model\Entity\PlanejamentoMovimentacaoProduto $planejamento_movimentacao_produto
 */
class PlanejamentoSolicitacaoPesagem extends Entity
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
        
        'planejamento_movimentacao_produto_id' => true,
        'data_hora_solicitacao' => true,
        'planejamento_movimentacao_produto' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
