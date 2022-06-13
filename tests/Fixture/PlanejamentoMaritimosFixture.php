<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PlanejamentoMaritimosFixture
 */
class PlanejamentoMaritimosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'situacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'faturar_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'berco_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'navio_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ncm_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'afreteador_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'agente_armador_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'oper_portuaria_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'carga_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tipo_viagem_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'sentido_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'porto_origem_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'porto_destino_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'numero' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'viagem_numero' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'versao' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'carpeta' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'escala' => ['type' => 'string', 'length' => 250, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'loa' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'fundeado' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'data_fundeio' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'data_registro' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'observacao' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'faturar_id' => ['type' => 'index', 'columns' => ['faturar_id'], 'length' => []],
            'berco_id' => ['type' => 'index', 'columns' => ['berco_id'], 'length' => []],
            'situacao_id' => ['type' => 'index', 'columns' => ['situacao_id'], 'length' => []],
            'navio_id' => ['type' => 'index', 'columns' => ['navio_id'], 'length' => []],
            'ncm_id' => ['type' => 'index', 'columns' => ['ncm_id'], 'length' => []],
            'afreteador_id' => ['type' => 'index', 'columns' => ['afreteador_id'], 'length' => []],
            'agente_armador_id' => ['type' => 'index', 'columns' => ['agente_armador_id'], 'length' => []],
            'oper_portuaria_id' => ['type' => 'index', 'columns' => ['oper_portuaria_id'], 'length' => []],
            'carga_id' => ['type' => 'index', 'columns' => ['carga_id'], 'length' => []],
            'tipo_viagem_id' => ['type' => 'index', 'columns' => ['tipo_viagem_id'], 'length' => []],
            'sentido_id' => ['type' => 'index', 'columns' => ['sentido_id'], 'length' => []],
            'porto_origem_id' => ['type' => 'index', 'columns' => ['porto_origem_id'], 'length' => []],
            'porto_destino_id' => ['type' => 'index', 'columns' => ['porto_destino_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'planejamento_maritimos_ibfk_1' => ['type' => 'foreign', 'columns' => ['situacao_id'], 'references' => ['situacao_programacao_maritimas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'planejamento_maritimos_ibfk_10' => ['type' => 'foreign', 'columns' => ['carga_id'], 'references' => ['tipos_cargas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'planejamento_maritimos_ibfk_11' => ['type' => 'foreign', 'columns' => ['tipo_viagem_id'], 'references' => ['tipos_viagens', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'planejamento_maritimos_ibfk_12' => ['type' => 'foreign', 'columns' => ['sentido_id'], 'references' => ['sentidos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'planejamento_maritimos_ibfk_13' => ['type' => 'foreign', 'columns' => ['porto_origem_id'], 'references' => ['procedencias', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'planejamento_maritimos_ibfk_14' => ['type' => 'foreign', 'columns' => ['porto_destino_id'], 'references' => ['procedencias', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'planejamento_maritimos_ibfk_2' => ['type' => 'foreign', 'columns' => ['faturar_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'planejamento_maritimos_ibfk_3' => ['type' => 'foreign', 'columns' => ['berco_id'], 'references' => ['bercos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'planejamento_maritimos_ibfk_4' => ['type' => 'foreign', 'columns' => ['situacao_id'], 'references' => ['situacao_programacao_maritimas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'planejamento_maritimos_ibfk_5' => ['type' => 'foreign', 'columns' => ['navio_id'], 'references' => ['veiculos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'planejamento_maritimos_ibfk_6' => ['type' => 'foreign', 'columns' => ['ncm_id'], 'references' => ['ncms', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'planejamento_maritimos_ibfk_7' => ['type' => 'foreign', 'columns' => ['afreteador_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'planejamento_maritimos_ibfk_8' => ['type' => 'foreign', 'columns' => ['agente_armador_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'planejamento_maritimos_ibfk_9' => ['type' => 'foreign', 'columns' => ['oper_portuaria_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'situacao_id' => 1,
                'faturar_id' => 1,
                'berco_id' => 1,
                'navio_id' => 1,
                'ncm_id' => 1,
                'afreteador_id' => 1,
                'agente_armador_id' => 1,
                'oper_portuaria_id' => 1,
                'carga_id' => 1,
                'tipo_viagem_id' => 1,
                'sentido_id' => 1,
                'porto_origem_id' => 1,
                'porto_destino_id' => 1,
                'numero' => 'Lorem ipsum dolor sit amet',
                'viagem_numero' => 'Lorem ipsum dolor sit amet',
                'versao' => 'Lorem ipsum dolor sit amet',
                'carpeta' => 'Lorem ipsum dolor sit amet',
                'escala' => 'Lorem ipsum dolor sit amet',
                'loa' => 'Lorem ipsum dolor sit amet',
                'fundeado' => 1,
                'data_fundeio' => '2020-01-27 17:47:12',
                'data_registro' => '2020-01-27',
                'observacao' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
            ],
        ];
        parent::init();
    }
}
