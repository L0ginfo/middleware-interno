<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FaturamentoFechamentoItensFixture
 */
class FaturamentoFechamentoItensFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'faturamento_fechamento_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'faturamento_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created_by' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'updated_by' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'updated' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'faturamento_fechamento_id' => ['type' => 'index', 'columns' => ['faturamento_fechamento_id'], 'length' => []],
            'faturamento_id' => ['type' => 'index', 'columns' => ['faturamento_id'], 'length' => []],
            'created_by' => ['type' => 'index', 'columns' => ['created_by'], 'length' => []],
            'updated_by' => ['type' => 'index', 'columns' => ['updated_by'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'faturamento_fechamento_itens_ibfk_1' => ['type' => 'foreign', 'columns' => ['faturamento_fechamento_id'], 'references' => ['faturamento_fechamentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'faturamento_fechamento_itens_ibfk_2' => ['type' => 'foreign', 'columns' => ['faturamento_id'], 'references' => ['faturamentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'faturamento_fechamento_itens_ibfk_3' => ['type' => 'foreign', 'columns' => ['created_by'], 'references' => ['usuarios', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'faturamento_fechamento_itens_ibfk_4' => ['type' => 'foreign', 'columns' => ['updated_by'], 'references' => ['usuarios', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'faturamento_fechamento_id' => 1,
                'faturamento_id' => 1,
                'created_by' => 1,
                'created' => '2020-01-29 11:31:37',
                'updated_by' => 1,
                'updated' => '2020-01-29 11:31:37',
            ],
        ];
        parent::init();
    }
}
