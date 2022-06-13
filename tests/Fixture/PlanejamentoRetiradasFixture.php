<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PlanejamentoRetiradasFixture
 */
class PlanejamentoRetiradasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'lote_codigo' => ['type' => 'string', 'length' => 15, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'codigo gerado automaticamente pelo sistema na criacao de documentacao de entrada', 'precision' => null, 'fixed' => null],
        'lote_item' => ['type' => 'string', 'length' => 15, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'codigo gerado automaticamente pelo sistema na criacao de documentacao de entrada', 'precision' => null, 'fixed' => null],
        'qtde_saldo' => ['type' => 'decimal', 'length' => 18, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'saldo da quantidade daquele item no estoque'],
        'peso_saldo' => ['type' => 'decimal', 'length' => 18, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'saldo do peso daquele item no estoque'],
        'm2_saldo' => ['type' => 'decimal', 'length' => 18, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'saldo do m2 daquele item no estoque'],
        'm3_saldo' => ['type' => 'decimal', 'length' => 18, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'saldo do m3 daquele item no estoque'],
        'lote' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Se o determinado produto e controlado por lote, o campo e preenchido', 'precision' => null, 'fixed' => null],
        'serie' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Se o determinado produto e controlado por serie, o campo e preenchido', 'precision' => null, 'fixed' => null],
        'validade' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Se o determinado produto e controlado por validade, o campo e preenchido', 'precision' => null],
        'unidade_medida_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'endereco_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'produto_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'usuario_created_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created_at' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'updated_at' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'status_estoque_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'lote_codigo' => ['type' => 'index', 'columns' => ['lote_codigo'], 'length' => []],
            'lote_item' => ['type' => 'index', 'columns' => ['lote_item'], 'length' => []],
            'lote_codigo_2' => ['type' => 'index', 'columns' => ['lote_codigo', 'lote_item'], 'length' => []],
            'usuario_created_id' => ['type' => 'index', 'columns' => ['usuario_created_id'], 'length' => []],
            'unidade_medida_id' => ['type' => 'index', 'columns' => ['unidade_medida_id'], 'length' => []],
            'endereco_id' => ['type' => 'index', 'columns' => ['endereco_id'], 'length' => []],
            'produto_id' => ['type' => 'index', 'columns' => ['produto_id'], 'length' => []],
            'status_estoque_id' => ['type' => 'index', 'columns' => ['status_estoque_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'planejamento_retiradas_ibfk_1' => ['type' => 'foreign', 'columns' => ['usuario_created_id'], 'references' => ['usuarios', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'planejamento_retiradas_ibfk_2' => ['type' => 'foreign', 'columns' => ['unidade_medida_id'], 'references' => ['unidade_medidas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'planejamento_retiradas_ibfk_3' => ['type' => 'foreign', 'columns' => ['endereco_id'], 'references' => ['enderecos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'planejamento_retiradas_ibfk_5' => ['type' => 'foreign', 'columns' => ['produto_id'], 'references' => ['produtos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'planejamento_retiradas_ibfk_6' => ['type' => 'foreign', 'columns' => ['status_estoque_id'], 'references' => ['status_estoques', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'lote_codigo' => 'Lorem ipsum d',
                'lote_item' => 'Lorem ipsum d',
                'qtde_saldo' => 1.5,
                'peso_saldo' => 1.5,
                'm2_saldo' => 1.5,
                'm3_saldo' => 1.5,
                'lote' => 'Lorem ipsum dolor sit amet',
                'serie' => 'Lorem ipsum dolor sit amet',
                'validade' => '2020-12-08 04:18:23',
                'unidade_medida_id' => 1,
                'endereco_id' => 1,
                'produto_id' => 1,
                'usuario_created_id' => 1,
                'created_at' => 1607411903,
                'updated_at' => 1607411903,
                'status_estoque_id' => 1,
            ],
        ];
        parent::init();
    }
}
