<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EntradaSaidaFluxosFixture
 */
class EntradaSaidaFluxosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'passagem_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'cancela_entrada_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'cancela_saida_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'data_hora_entrada' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'data_hora_saida' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'updated_by' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'programacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'balanca_entrada_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'balanca_saida_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tipo_fluxo_entrada' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'tipo_fluxo_saida' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'tipo_entrada' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'tipo_saida' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'cancela_entrada_id' => ['type' => 'index', 'columns' => ['cancela_entrada_id'], 'length' => []],
            'cancela_saida_id' => ['type' => 'index', 'columns' => ['cancela_saida_id'], 'length' => []],
            'updated_by' => ['type' => 'index', 'columns' => ['updated_by'], 'length' => []],
            'programacao_id' => ['type' => 'index', 'columns' => ['programacao_id'], 'length' => []],
            'balanca_entrada_id' => ['type' => 'index', 'columns' => ['balanca_entrada_id'], 'length' => []],
            'balanca_saida_id' => ['type' => 'index', 'columns' => ['balanca_saida_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'entrada_saida_fluxos_ibfk_1' => ['type' => 'foreign', 'columns' => ['cancela_entrada_id'], 'references' => ['cancelas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'entrada_saida_fluxos_ibfk_2' => ['type' => 'foreign', 'columns' => ['cancela_saida_id'], 'references' => ['cancelas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'entrada_saida_fluxos_ibfk_3' => ['type' => 'foreign', 'columns' => ['updated_by'], 'references' => ['usuarios', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'entrada_saida_fluxos_ibfk_4' => ['type' => 'foreign', 'columns' => ['programacao_id'], 'references' => ['programacoes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'entrada_saida_fluxos_ibfk_5' => ['type' => 'foreign', 'columns' => ['balanca_entrada_id'], 'references' => ['balancas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'entrada_saida_fluxos_ibfk_6' => ['type' => 'foreign', 'columns' => ['balanca_saida_id'], 'references' => ['balancas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'passagem_id' => 1,
                'cancela_entrada_id' => 1,
                'cancela_saida_id' => 1,
                'data_hora_entrada' => '2021-05-03 11:30:04',
                'data_hora_saida' => '2021-05-03 11:30:04',
                'updated_by' => 1,
                'programacao_id' => 1,
                'balanca_entrada_id' => 1,
                'balanca_saida_id' => 1,
                'tipo_fluxo_entrada' => 'Lorem ipsum dolor sit amet',
                'tipo_fluxo_saida' => 'Lorem ipsum dolor sit amet',
                'tipo_entrada' => 'Lorem ipsum dolor sit amet',
                'tipo_saida' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
