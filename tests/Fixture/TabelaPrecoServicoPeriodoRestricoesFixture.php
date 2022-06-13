<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TabelaPrecoServicoPeriodoRestricoesFixture
 */
class TabelaPrecoServicoPeriodoRestricoesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'tabela_preco_servico_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tabela_preco_periodo_arm_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'tabela_preco_servico_id' => ['type' => 'index', 'columns' => ['tabela_preco_servico_id'], 'length' => []],
            'tabela_preco_periodo_arm_id' => ['type' => 'index', 'columns' => ['tabela_preco_periodo_arm_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'tabela_preco_servico_periodo_restricoes_ibfk_1' => ['type' => 'foreign', 'columns' => ['tabela_preco_servico_id'], 'references' => ['tabelas_precos_servicos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'tabela_preco_servico_periodo_restricoes_ibfk_2' => ['type' => 'foreign', 'columns' => ['tabela_preco_periodo_arm_id'], 'references' => ['tabelas_precos_periodos_arms', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'tabela_preco_servico_id' => 1,
                'tabela_preco_periodo_arm_id' => 1,
            ],
        ];
        parent::init();
    }
}
