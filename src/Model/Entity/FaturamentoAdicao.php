<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FaturamentoAdicao Entity
 *
 * @property int $id
 * @property string|null $numero_periodo
 * @property float $valor_periodo
 * @property float $valor_periodo_servico
 * @property float $valor_restricao_servico
 * @property float $valor_final_servico
 * @property float $desconto
 * @property int $restricao_servico
 * @property int $insento
 * @property \Cake\I18n\Date|null $vencimento_periodo
 * @property int|null $adicao_id
 * @property int|null $faturamento_id
 * @property int|null $tabela_preco_id
 * @property int|null $tab_preco_per_arm_id
 *
 * @property \App\Model\Entity\LiberacaoDocumentalDecisaoTabelaPrecoAdicao $liberacao_documental_decisao_tabela_preco_adicao
 * @property \App\Model\Entity\Faturamento $faturamento
 * @property \App\Model\Entity\TabelasPreco $tabelas_preco
 * @property \App\Model\Entity\TabelasPrecosPeriodosArm $tabelas_precos_periodos_arm
 */
class FaturamentoAdicao extends Entity
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
        
        'numero_periodo' => true,
        'valor_periodo' => true,
        'valor_periodo_servico' => true,
        'valor_restricao_servico' => true,
        'valor_final_servico' => true,
        'desconto' => true,
        'restricao_servico' => true,
        'insento' => true,
        'vencimento_periodo' => true,
        'adicao_id' => true,
        'faturamento_id' => true,
        'tabela_preco_id' => true,
        'tab_preco_per_arm_id' => true,
        'liberacao_documental_decisao_tabela_preco_adicao' => true,
        'faturamento' => true,
        'tabelas_preco' => true,
        'tabelas_precos_periodos_arm' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
