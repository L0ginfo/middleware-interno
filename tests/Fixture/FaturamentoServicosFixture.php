<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FaturamentoServicosFixture
 */
class FaturamentoServicosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'quantidade' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'valor_unitario' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'valor_total' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'tabela_preco_servico_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'faturamento_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'empresa_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'tabela_preco_servico_id' => ['type' => 'index', 'columns' => ['tabela_preco_servico_id'], 'length' => []],
            'faturamento_id' => ['type' => 'index', 'columns' => ['faturamento_id'], 'length' => []],
            'empresa_id' => ['type' => 'index', 'columns' => ['empresa_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'faturamento_servicos_ibfk_1' => ['type' => 'foreign', 'columns' => ['tabela_preco_servico_id'], 'references' => ['tabelas_precos_servicos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'faturamento_servicos_ibfk_2' => ['type' => 'foreign', 'columns' => ['faturamento_id'], 'references' => ['faturamentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'faturamento_servicos_ibfk_3' => ['type' => 'foreign', 'columns' => ['empresa_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'quantidade' => 1.5,
                'valor_unitario' => 1.5,
                'valor_total' => 1.5,
                'tabela_preco_servico_id' => 1,
                'faturamento_id' => 1,
                'empresa_id' => 1
            ],
        ];
        parent::init();
    }
}
