<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TabPrecosValidaServicosFixture
 */
class TabPrecosValidaServicosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'tab_preco_servico_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'campo_sistema_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'operador_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'valor_inicio' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'valor_final' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'tab_preco_servico_id' => ['type' => 'index', 'columns' => ['tab_preco_servico_id'], 'length' => []],
            'campo_sistema_id' => ['type' => 'index', 'columns' => ['campo_sistema_id'], 'length' => []],
            'operador_id' => ['type' => 'index', 'columns' => ['operador_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'tab_precos_valida_servicos_ibfk_1' => ['type' => 'foreign', 'columns' => ['tab_preco_servico_id'], 'references' => ['tabelas_precos_servicos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'tab_precos_valida_servicos_ibfk_2' => ['type' => 'foreign', 'columns' => ['campo_sistema_id'], 'references' => ['sistema_campos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'tab_precos_valida_servicos_ibfk_3' => ['type' => 'foreign', 'columns' => ['operador_id'], 'references' => ['operadores', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'tab_preco_servico_id' => 1,
                'campo_sistema_id' => 1,
                'operador_id' => 1,
                'valor_inicio' => 'Lorem ipsum dolor ',
                'valor_final' => 'Lorem ipsum dolor '
            ],
        ];
        parent::init();
    }
}
