<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TabelasPrecosPeriodosArmsFixture
 */
class TabelasPrecosPeriodosArmsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'tabela_preco_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'dias' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'periodo_inicial' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'periodo_final' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'valor' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'campo_valor_sistema_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'carencia' => ['type' => 'integer', 'length' => 1, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'prorata' => ['type' => 'integer', 'length' => 1, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'valor_minimo' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'servico_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tipo_valor_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'tabela_preco_id' => ['type' => 'index', 'columns' => ['tabela_preco_id'], 'length' => []],
            'campo_valor_sistema_id' => ['type' => 'index', 'columns' => ['campo_valor_sistema_id'], 'length' => []],
            'servico_id' => ['type' => 'index', 'columns' => ['servico_id'], 'length' => []],
            'tipo_valor_id' => ['type' => 'index', 'columns' => ['tipo_valor_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_tabelas_precos_periodos_arms_tipos_valores' => ['type' => 'foreign', 'columns' => ['tipo_valor_id'], 'references' => ['tipos_valores', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'tabelas_precos_periodos_arms_ibfk_1' => ['type' => 'foreign', 'columns' => ['tabela_preco_id'], 'references' => ['tabelas_precos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'tabelas_precos_periodos_arms_ibfk_2' => ['type' => 'foreign', 'columns' => ['campo_valor_sistema_id'], 'references' => ['sistema_campos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'tabelas_precos_periodos_arms_ibfk_3' => ['type' => 'foreign', 'columns' => ['servico_id'], 'references' => ['servicos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'tabela_preco_id' => 1,
                'dias' => 1,
                'periodo_inicial' => 1,
                'periodo_final' => 1,
                'valor' => 1.5,
                'campo_valor_sistema_id' => 1,
                'carencia' => 1,
                'prorata' => 1,
                'valor_minimo' => 1.5,
                'servico_id' => 1,
                'tipo_valor_id' => 1
            ],
        ];
        parent::init();
    }
}
