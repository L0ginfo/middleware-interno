<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PlanejamentoMovimentacaoProdutosFixture
 */
class PlanejamentoMovimentacaoProdutosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'data_hora_inicio' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'data_hora_fim' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'produto_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'operacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'endereco_origem_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'endereco_destino_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'controle_producao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'produto_id' => ['type' => 'index', 'columns' => ['produto_id'], 'length' => []],
            'operacao_id' => ['type' => 'index', 'columns' => ['operacao_id'], 'length' => []],
            'endereco_origem_id' => ['type' => 'index', 'columns' => ['endereco_origem_id'], 'length' => []],
            'endereco_destino_id' => ['type' => 'index', 'columns' => ['endereco_destino_id'], 'length' => []],
            'controle_producao_id' => ['type' => 'index', 'columns' => ['controle_producao_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'planejamento_movimentacao_produtos_ibfk_1' => ['type' => 'foreign', 'columns' => ['produto_id'], 'references' => ['produtos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'planejamento_movimentacao_produtos_ibfk_2' => ['type' => 'foreign', 'columns' => ['operacao_id'], 'references' => ['operacoes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'planejamento_movimentacao_produtos_ibfk_3' => ['type' => 'foreign', 'columns' => ['endereco_origem_id'], 'references' => ['enderecos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'planejamento_movimentacao_produtos_ibfk_4' => ['type' => 'foreign', 'columns' => ['endereco_destino_id'], 'references' => ['enderecos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'planejamento_movimentacao_produtos_ibfk_5' => ['type' => 'foreign', 'columns' => ['controle_producao_id'], 'references' => ['controle_producoes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'data_hora_inicio' => '2021-10-22 14:35:18',
                'data_hora_fim' => '2021-10-22 14:35:18',
                'produto_id' => 1,
                'operacao_id' => 1,
                'endereco_origem_id' => 1,
                'endereco_destino_id' => 1,
                'controle_producao_id' => 1,
            ],
        ];
        parent::init();
    }
}
