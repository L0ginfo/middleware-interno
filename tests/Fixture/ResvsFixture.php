<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ResvsFixture
 */
class ResvsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'resv_codigo' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'data_hora_chegada' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'data_hora_entrada' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'data_hora_saida' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'operacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'veiculo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'transportador_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'pessoa_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'modal_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'portaria_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'empresa_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'operacao_id' => ['type' => 'index', 'columns' => ['operacao_id'], 'length' => []],
            'veiculo_id' => ['type' => 'index', 'columns' => ['veiculo_id'], 'length' => []],
            'transportador_id' => ['type' => 'index', 'columns' => ['transportador_id'], 'length' => []],
            'pessoa_id' => ['type' => 'index', 'columns' => ['pessoa_id'], 'length' => []],
            'modal_id' => ['type' => 'index', 'columns' => ['modal_id'], 'length' => []],
            'portaria_id' => ['type' => 'index', 'columns' => ['portaria_id'], 'length' => []],
            'empresa_id' => ['type' => 'index', 'columns' => ['empresa_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_resvs_empresas' => ['type' => 'foreign', 'columns' => ['empresa_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'resvs_ibfk_1' => ['type' => 'foreign', 'columns' => ['operacao_id'], 'references' => ['operacoes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'resvs_ibfk_2' => ['type' => 'foreign', 'columns' => ['veiculo_id'], 'references' => ['veiculos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'resvs_ibfk_3' => ['type' => 'foreign', 'columns' => ['transportador_id'], 'references' => ['transportadoras', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'resvs_ibfk_4' => ['type' => 'foreign', 'columns' => ['pessoa_id'], 'references' => ['pessoas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'resvs_ibfk_5' => ['type' => 'foreign', 'columns' => ['modal_id'], 'references' => ['modais', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'resvs_ibfk_6' => ['type' => 'foreign', 'columns' => ['portaria_id'], 'references' => ['portarias', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'resv_codigo' => 'Lorem ipsum dolor ',
                'data_hora_chegada' => '2019-10-02 18:49:52',
                'data_hora_entrada' => '2019-10-02 18:49:52',
                'data_hora_saida' => '2019-10-02 18:49:52',
                'operacao_id' => 1,
                'veiculo_id' => 1,
                'transportador_id' => 1,
                'pessoa_id' => 1,
                'modal_id' => 1,
                'portaria_id' => 1,
                'empresa_id' => 1
            ],
        ];
        parent::init();
    }
}
