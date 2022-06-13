<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TabelasPrecosServico Entity
 *
 * @property int $id
 * @property int $empresa_id
 * @property int $tabela_preco_id
 * @property int $servico_id
 * @property int $tipo_valor_id
 * @property float $valor
 * @property int $campo_valor_sistema_id
 * @property float $desconto_percentual_serv
 *
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\TabelasPreco $tabelas_preco
 * @property \App\Model\Entity\Servico $servico
 * @property \App\Model\Entity\TiposValore $tipos_valore
 * @property \App\Model\Entity\SistemaCampo $sistema_campo
 */
class TabelasPrecosServico extends Entity
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
    protected $_accessible = [
        'tabela_preco_id' => true,
        'servico_id' => true,
        'tipo_valor_id' => true,
        'empresa_id' => true,
        'valor' => true,
        'valor_minimo' => true,
        'campo_valor_sistema_id' => true,
        'desconto_percentual_serv' => true,
        'gera_cobranca_faturamento_complementar_com_baixas' => true,
        'empresa' => true,
        'tabelas_preco' => true,
        'servico' => true,
        'tipos_valore' => true,
        'sistema_campo' => true
    ];
}
