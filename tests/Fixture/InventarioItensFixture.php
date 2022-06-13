<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InventarioItensFixture
 */
class InventarioItensFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'inventario_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'endereco_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'etiqueta_produto_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'quantidade_lida' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'operador_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'inventario_id' => ['type' => 'index', 'columns' => ['inventario_id'], 'length' => []],
            'endereco_id' => ['type' => 'index', 'columns' => ['endereco_id'], 'length' => []],
            'etiqueta_produto_id' => ['type' => 'index', 'columns' => ['etiqueta_produto_id'], 'length' => []],
            'operador_id' => ['type' => 'index', 'columns' => ['operador_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'inventario_itens_ibfk_1' => ['type' => 'foreign', 'columns' => ['inventario_id'], 'references' => ['inventarios', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'inventario_itens_ibfk_2' => ['type' => 'foreign', 'columns' => ['endereco_id'], 'references' => ['enderecos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'inventario_itens_ibfk_3' => ['type' => 'foreign', 'columns' => ['etiqueta_produto_id'], 'references' => ['etiqueta_produtos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'inventario_itens_ibfk_4' => ['type' => 'foreign', 'columns' => ['operador_id'], 'references' => ['operadores', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'inventario_id' => 1,
                'endereco_id' => 1,
                'etiqueta_produto_id' => 1,
                'quantidade_lida' => 1.5,
                'operador_id' => 1,
            ],
        ];
        parent::init();
    }
}
