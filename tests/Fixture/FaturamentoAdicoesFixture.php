<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FaturamentoAdicoesFixture
 */
class FaturamentoAdicoesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'numero_periodo' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'valor_periodo' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'valor_periodo_servico' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'valor_restricao_servico' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'valor_final_servico' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'desconto' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'restricao_servico' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'insento' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'vencimento_periodo' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'adicao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'faturamento_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tabela_preco_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tab_preco_per_arm_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'adicao_id' => ['type' => 'index', 'columns' => ['adicao_id'], 'length' => []],
            'faturamento_id' => ['type' => 'index', 'columns' => ['faturamento_id'], 'length' => []],
            'tabela_preco_id' => ['type' => 'index', 'columns' => ['tabela_preco_id'], 'length' => []],
            'tab_preco_per_arm_id' => ['type' => 'index', 'columns' => ['tab_preco_per_arm_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'faturamento_adicoes_ibfk_1' => ['type' => 'foreign', 'columns' => ['adicao_id'], 'references' => ['liberacao_documental_decisao_tabela_preco_adicoes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'faturamento_adicoes_ibfk_2' => ['type' => 'foreign', 'columns' => ['faturamento_id'], 'references' => ['faturamentos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'faturamento_adicoes_ibfk_3' => ['type' => 'foreign', 'columns' => ['tabela_preco_id'], 'references' => ['tabelas_precos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'faturamento_adicoes_ibfk_4' => ['type' => 'foreign', 'columns' => ['tab_preco_per_arm_id'], 'references' => ['tabelas_precos_periodos_arms', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'numero_periodo' => 'Lorem ipsum dolor sit amet',
                'valor_periodo' => 1.5,
                'valor_periodo_servico' => 1.5,
                'valor_restricao_servico' => 1.5,
                'valor_final_servico' => 1.5,
                'desconto' => 1.5,
                'restricao_servico' => 1,
                'insento' => 1,
                'vencimento_periodo' => '2021-11-09',
                'adicao_id' => 1,
                'faturamento_id' => 1,
                'tabela_preco_id' => 1,
                'tab_preco_per_arm_id' => 1,
            ],
        ];
        parent::init();
    }
}
