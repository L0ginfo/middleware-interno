<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TabelasPrecosServicosFixture
 */
class TabelasPrecosServicosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'empresa_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tabela_preco_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'servico_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tipo_valor_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'valor' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'campo_valor_sistema_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'desconto_percentual_serv' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'empresa_id' => ['type' => 'index', 'columns' => ['empresa_id'], 'length' => []],
            'tabela_preco_id' => ['type' => 'index', 'columns' => ['tabela_preco_id'], 'length' => []],
            'servico_id' => ['type' => 'index', 'columns' => ['servico_id'], 'length' => []],
            'tipo_valor_id' => ['type' => 'index', 'columns' => ['tipo_valor_id'], 'length' => []],
            'campo_valor_sistema_id' => ['type' => 'index', 'columns' => ['campo_valor_sistema_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id', 'empresa_id'], 'length' => []],
            'tabelas_precos_servicos_ibfk_1' => ['type' => 'foreign', 'columns' => ['empresa_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'tabelas_precos_servicos_ibfk_2' => ['type' => 'foreign', 'columns' => ['tabela_preco_id'], 'references' => ['tabelas_precos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'tabelas_precos_servicos_ibfk_3' => ['type' => 'foreign', 'columns' => ['servico_id'], 'references' => ['servicos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'tabelas_precos_servicos_ibfk_4' => ['type' => 'foreign', 'columns' => ['tipo_valor_id'], 'references' => ['tipos_valores', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'tabelas_precos_servicos_ibfk_5' => ['type' => 'foreign', 'columns' => ['campo_valor_sistema_id'], 'references' => ['sistema_campos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'empresa_id' => 1,
                'tabela_preco_id' => 1,
                'servico_id' => 1,
                'tipo_valor_id' => 1,
                'valor' => 1.5,
                'campo_valor_sistema_id' => 1,
                'desconto_percentual_serv' => 1.5
            ],
        ];
        parent::init();
    }
}
