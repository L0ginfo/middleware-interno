<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FaturamentoBaixasFixture
 */
class FaturamentoBaixasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'sequencia_baixa' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'data_baixa' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'agencia' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'conta' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'valor_baixa' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'tipo_pagamento_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'banco_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'faturamento_armazenagem_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'banco_id' => ['type' => 'index', 'columns' => ['banco_id'], 'length' => []],
            'tipo_pagamento_id' => ['type' => 'index', 'columns' => ['tipo_pagamento_id'], 'length' => []],
            'faturamento_armazenagem_id' => ['type' => 'index', 'columns' => ['faturamento_armazenagem_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'faturamento_baixas_ibfk_2' => ['type' => 'foreign', 'columns' => ['tipo_pagamento_id'], 'references' => ['tipo_pagamentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'faturamento_baixas_ibfk_3' => ['type' => 'foreign', 'columns' => ['banco_id'], 'references' => ['bancos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'faturamento_baixas_ibfk_4' => ['type' => 'foreign', 'columns' => ['faturamento_armazenagem_id'], 'references' => ['faturamento_armazenagens', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'sequencia_baixa' => 1,
                'data_baixa' => '2019-11-14 16:38:24',
                'agencia' => 'Lorem ipsum dolor sit amet',
                'conta' => 'Lorem ipsum dolor sit amet',
                'valor_baixa' => 'Lorem ipsum dolor sit amet',
                'tipo_pagamento_id' => 1,
                'banco_id' => 1,
                'faturamento_armazenagem_id' => 1
            ],
        ];
        parent::init();
    }
}
