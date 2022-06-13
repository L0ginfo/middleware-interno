<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TabelasPrecosOpcoesFixture
 */
class TabelasPrecosOpcoesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'tabela_preco_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tipo_empresa_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'empresa_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'tabela_preco_id' => ['type' => 'index', 'columns' => ['tabela_preco_id'], 'length' => []],
            'tipo_empresa_id' => ['type' => 'index', 'columns' => ['tipo_empresa_id'], 'length' => []],
            'empresa_id' => ['type' => 'index', 'columns' => ['empresa_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'tabelas_precos_opcoes_ibfk_1' => ['type' => 'foreign', 'columns' => ['tabela_preco_id'], 'references' => ['tabelas_precos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'tabelas_precos_opcoes_ibfk_2' => ['type' => 'foreign', 'columns' => ['tipo_empresa_id'], 'references' => ['tipos_empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'tabelas_precos_opcoes_ibfk_3' => ['type' => 'foreign', 'columns' => ['empresa_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'tipo_empresa_id' => 1,
                'empresa_id' => 1
            ],
        ];
        parent::init();
    }
}
