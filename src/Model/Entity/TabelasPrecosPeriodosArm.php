<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TabelasPrecosPeriodosArm Entity
 *
 * @property int $id
 * @property int $tabela_preco_id
 * @property int $dias
 * @property int $periodo_inicial
 * @property int|null $periodo_final
 * @property float|null $valor
 * @property int|null $campo_valor_sistema_id
 * @property int $carencia
 * @property int $prorata
 * @property float|null $valor_minimo
 * @property int|null $servico_id
 * @property int $tipo_valor_id
 *
 * @property \App\Model\Entity\TabelasPreco $tabelas_preco
 * @property \App\Model\Entity\SistemaCampo $sistema_campo
 * @property \App\Model\Entity\Servico $servico
 */
class TabelasPrecosPeriodosArm extends Entity
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
        'dias' => true,
        'periodo_inicial' => true,
        'periodo_final' => true,
        'valor' => true,
        'campo_valor_sistema_id' => true,
        'carencia' => true,
        'prorata' => true,
        'valor_minimo' => true,
        'acumula_quando_der_valor_minimo' => true,
        'tabela_preco_periodicidade_id' =>true,
        'servico_id' => true,
        'tipo_valor_id' => true,
        'tabelas_preco' => true,
        'sistema_campo' => true,
        'servico' => true
    ];
}
