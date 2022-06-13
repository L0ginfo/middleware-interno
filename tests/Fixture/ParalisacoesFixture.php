<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ParalisacoesFixture
 */
class ParalisacoesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'descricao' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'data_hora_inicio' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'data_hora_fim' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'detectada_automaticamente' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'paralisacao_motivo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'planejamento_maritimo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'plano_carga_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'plano_carga_porao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'porao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'plano_carga_tipo_mercadoria_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created_at' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'updated_at' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'paralisacao_motivo_id' => ['type' => 'index', 'columns' => ['paralisacao_motivo_id'], 'length' => []],
            'planejamento_maritimo_id' => ['type' => 'index', 'columns' => ['planejamento_maritimo_id'], 'length' => []],
            'plano_carga_id' => ['type' => 'index', 'columns' => ['plano_carga_id'], 'length' => []],
            'plano_carga_porao_id' => ['type' => 'index', 'columns' => ['plano_carga_porao_id'], 'length' => []],
            'porao_id' => ['type' => 'index', 'columns' => ['porao_id'], 'length' => []],
            'plano_carga_tipo_mercadoria_id' => ['type' => 'index', 'columns' => ['plano_carga_tipo_mercadoria_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'paralisacoes_ibfk_1' => ['type' => 'foreign', 'columns' => ['paralisacao_motivo_id'], 'references' => ['paralisacao_motivos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'paralisacoes_ibfk_2' => ['type' => 'foreign', 'columns' => ['planejamento_maritimo_id'], 'references' => ['planejamento_maritimos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'paralisacoes_ibfk_3' => ['type' => 'foreign', 'columns' => ['plano_carga_id'], 'references' => ['plano_cargas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'paralisacoes_ibfk_4' => ['type' => 'foreign', 'columns' => ['plano_carga_porao_id'], 'references' => ['plano_carga_poroes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'paralisacoes_ibfk_5' => ['type' => 'foreign', 'columns' => ['porao_id'], 'references' => ['poroes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'paralisacoes_ibfk_6' => ['type' => 'foreign', 'columns' => ['plano_carga_tipo_mercadoria_id'], 'references' => ['plano_carga_tipo_mercadorias', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'descricao' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'data_hora_inicio' => '2021-01-25 11:14:00',
                'data_hora_fim' => '2021-01-25 11:14:00',
                'detectada_automaticamente' => 1,
                'paralisacao_motivo_id' => 1,
                'planejamento_maritimo_id' => 1,
                'plano_carga_id' => 1,
                'plano_carga_porao_id' => 1,
                'porao_id' => 1,
                'plano_carga_tipo_mercadoria_id' => 1,
                'created_at' => 1611584040,
                'updated_at' => 1611584040,
            ],
        ];
        parent::init();
    }
}
