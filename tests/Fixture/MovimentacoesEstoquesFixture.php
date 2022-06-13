<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MovimentacoesEstoquesFixture
 */
class MovimentacoesEstoquesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'estoque_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'endereco_origem_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'endereco_destino_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tipo_movimentacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'data_hora' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'quantidade_movimentada' => ['type' => 'decimal', 'length' => 18, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'm2_movimentada' => ['type' => 'decimal', 'length' => 18, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'm3_movimentada' => ['type' => 'decimal', 'length' => 18, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'estoque_id' => ['type' => 'index', 'columns' => ['estoque_id'], 'length' => []],
            'endereco_origem_id' => ['type' => 'index', 'columns' => ['endereco_origem_id'], 'length' => []],
            'endereco_destino_id' => ['type' => 'index', 'columns' => ['endereco_destino_id'], 'length' => []],
            'tipo_movimentacao_id' => ['type' => 'index', 'columns' => ['tipo_movimentacao_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'movimentacoes_estoques_ibfk_1' => ['type' => 'foreign', 'columns' => ['estoque_id'], 'references' => ['estoques', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'movimentacoes_estoques_ibfk_2' => ['type' => 'foreign', 'columns' => ['endereco_origem_id'], 'references' => ['enderecos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'movimentacoes_estoques_ibfk_3' => ['type' => 'foreign', 'columns' => ['endereco_destino_id'], 'references' => ['enderecos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'movimentacoes_estoques_ibfk_4' => ['type' => 'foreign', 'columns' => ['tipo_movimentacao_id'], 'references' => ['tipo_movimentacoes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'estoque_id' => 1,
                'endereco_origem_id' => 1,
                'endereco_destino_id' => 1,
                'tipo_movimentacao_id' => 1,
                'data_hora' => '2019-11-05 12:45:58',
                'quantidade_movimentada' => 1.5,
                'm2_movimentada' => 1.5,
                'm3_movimentada' => 1.5
            ],
        ];
        parent::init();
    }
}
