<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProgramacoesFixture
 */
class ProgramacoesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'data_hora_programada' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'data_hora_chegada' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'operacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'veiculo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'transportadora_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'pessoa_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'modal_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'portaria_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'embalagem_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'resv_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'peso_maximo' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'peso_estimado_carga' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'peso_pallets' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'observacao' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'resv_id' => ['type' => 'index', 'columns' => ['resv_id'], 'length' => []],
            'operacao_id' => ['type' => 'index', 'columns' => ['operacao_id'], 'length' => []],
            'veiculo_id' => ['type' => 'index', 'columns' => ['veiculo_id'], 'length' => []],
            'transportadora_id' => ['type' => 'index', 'columns' => ['transportadora_id'], 'length' => []],
            'pessoa_id' => ['type' => 'index', 'columns' => ['pessoa_id'], 'length' => []],
            'modal_id' => ['type' => 'index', 'columns' => ['modal_id'], 'length' => []],
            'portaria_id' => ['type' => 'index', 'columns' => ['portaria_id'], 'length' => []],
            'embalagem_id' => ['type' => 'index', 'columns' => ['embalagem_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'programacoes_ibfk_1' => ['type' => 'foreign', 'columns' => ['resv_id'], 'references' => ['resvs', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'programacoes_ibfk_2' => ['type' => 'foreign', 'columns' => ['operacao_id'], 'references' => ['operacoes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'programacoes_ibfk_3' => ['type' => 'foreign', 'columns' => ['veiculo_id'], 'references' => ['veiculos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'programacoes_ibfk_4' => ['type' => 'foreign', 'columns' => ['transportadora_id'], 'references' => ['transportadoras', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'programacoes_ibfk_5' => ['type' => 'foreign', 'columns' => ['pessoa_id'], 'references' => ['pessoas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'programacoes_ibfk_6' => ['type' => 'foreign', 'columns' => ['modal_id'], 'references' => ['modais', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'programacoes_ibfk_7' => ['type' => 'foreign', 'columns' => ['portaria_id'], 'references' => ['portarias', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'programacoes_ibfk_8' => ['type' => 'foreign', 'columns' => ['embalagem_id'], 'references' => ['embalagens', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'data_hora_programada' => '2020-12-27 21:28:14',
                'data_hora_chegada' => '2020-12-27 21:28:14',
                'operacao_id' => 1,
                'veiculo_id' => 1,
                'transportadora_id' => 1,
                'pessoa_id' => 1,
                'modal_id' => 1,
                'portaria_id' => 1,
                'embalagem_id' => 1,
                'resv_id' => 1,
                'peso_maximo' => 1.5,
                'peso_estimado_carga' => 1.5,
                'peso_pallets' => 1.5,
                'observacao' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            ],
        ];
        parent::init();
    }
}
