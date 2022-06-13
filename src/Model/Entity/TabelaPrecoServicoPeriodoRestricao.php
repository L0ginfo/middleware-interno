<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TabelaPrecoServicoPeriodoRestricao Entity
 *
 * @property int $id
 * @property int|null $tabela_preco_servico_id
 * @property int|null $tabela_preco_periodo_arm_id
 *
 * @property \App\Model\Entity\TabelasPrecosServico $tabelas_precos_servico
 * @property \App\Model\Entity\TabelasPrecosPeriodosArm $tabelas_precos_periodos_arm
 */
class TabelaPrecoServicoPeriodoRestricao extends Entity
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
        
        'tabela_preco_servico_id' => true,
        'tabela_preco_periodo_arm_id' => true,
        'tabelas_precos_servico' => true,
        'tabelas_precos_periodos_arm' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
