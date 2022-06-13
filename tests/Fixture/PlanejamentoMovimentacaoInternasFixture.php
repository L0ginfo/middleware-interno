<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PlanejamentoMovimentacaoInternasFixture
 */
class PlanejamentoMovimentacaoInternasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'planejamento_movimentacao_produto_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'resv_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'endereco_origem_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'endereco_destino_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'endereco_destino_planejado_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'lote_codigo' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'produto_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'planejamento_movimentacao_produto_id' => ['type' => 'index', 'columns' => ['planejamento_movimentacao_produto_id'], 'length' => []],
            'resv_id' => ['type' => 'index', 'columns' => ['resv_id'], 'length' => []],
            'endereco_origem_id' => ['type' => 'index', 'columns' => ['endereco_origem_id'], 'length' => []],
            'endereco_destino_id' => ['type' => 'index', 'columns' => ['endereco_destino_id'], 'length' => []],
            'endereco_destino_planejado_id' => ['type' => 'index', 'columns' => ['endereco_destino_planejado_id'], 'length' => []],
            'produto_id' => ['type' => 'index', 'columns' => ['produto_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'planejamento_movimentacao_internas_ibfk_1' => ['type' => 'foreign', 'columns' => ['planejamento_movimentacao_produto_id'], 'references' => ['planejamento_movimentacao_produtos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'planejamento_movimentacao_internas_ibfk_2' => ['type' => 'foreign', 'columns' => ['resv_id'], 'references' => ['resvs', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'planejamento_movimentacao_internas_ibfk_3' => ['type' => 'foreign', 'columns' => ['endereco_origem_id'], 'references' => ['enderecos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'planejamento_movimentacao_internas_ibfk_4' => ['type' => 'foreign', 'columns' => ['endereco_destino_id'], 'references' => ['enderecos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'planejamento_movimentacao_internas_ibfk_5' => ['type' => 'foreign', 'columns' => ['endereco_destino_planejado_id'], 'references' => ['enderecos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'planejamento_movimentacao_internas_ibfk_6' => ['type' => 'foreign', 'columns' => ['produto_id'], 'references' => ['produtos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'planejamento_movimentacao_produto_id' => 1,
                'resv_id' => 1,
                'endereco_origem_id' => 1,
                'endereco_destino_id' => 1,
                'endereco_destino_planejado_id' => 1,
                'lote_codigo' => 'Lorem ipsum dolor sit amet',
                'produto_id' => 1,
            ],
        ];
        parent::init();
    }
}
