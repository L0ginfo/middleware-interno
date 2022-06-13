<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FormacaoCargaNfPedidosFixture
 */
class FormacaoCargaNfPedidosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'formacao_carga_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'numero_nf' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'separacao_carga_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'formacao_carga_id' => ['type' => 'index', 'columns' => ['formacao_carga_id'], 'length' => []],
            'separacao_carga_id' => ['type' => 'index', 'columns' => ['separacao_carga_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'formacao_carga_nf_pedidos_ibfk_1' => ['type' => 'foreign', 'columns' => ['formacao_carga_id'], 'references' => ['formacao_cargas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'formacao_carga_nf_pedidos_ibfk_2' => ['type' => 'foreign', 'columns' => ['separacao_carga_id'], 'references' => ['separacao_cargas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'formacao_carga_id' => 1,
                'numero_nf' => 'Lorem ipsum dolor sit amet',
                'separacao_carga_id' => 1,
            ],
        ];
        parent::init();
    }
}
