<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FaturamentoArmazenagensFixture
 */
class FaturamentoArmazenagensFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'periodo_dias' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'vencimento_periodo' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'valor_periodo' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'tab_preco_valida_per_arm_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'faturamento_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'empresa_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'tab_preco_valida_per_arm_id' => ['type' => 'index', 'columns' => ['tab_preco_valida_per_arm_id'], 'length' => []],
            'faturamento_id' => ['type' => 'index', 'columns' => ['faturamento_id'], 'length' => []],
            'empresa_id' => ['type' => 'index', 'columns' => ['empresa_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'faturamento_armazenagens_ibfk_1' => ['type' => 'foreign', 'columns' => ['tab_preco_valida_per_arm_id'], 'references' => ['tab_precos_valida_per_arms', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'faturamento_armazenagens_ibfk_2' => ['type' => 'foreign', 'columns' => ['faturamento_id'], 'references' => ['faturamentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'faturamento_armazenagens_ibfk_3' => ['type' => 'foreign', 'columns' => ['empresa_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'periodo_dias' => 1,
                'vencimento_periodo' => '2019-11-06 16:43:19',
                'valor_periodo' => 1.5,
                'tab_preco_valida_per_arm_id' => 1,
                'faturamento_id' => 1,
                'empresa_id' => 1
            ],
        ];
        parent::init();
    }
}
