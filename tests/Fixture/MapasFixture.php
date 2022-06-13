<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MapasFixture
 */
class MapasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'comissario_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'agente_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'despachante_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'madeira' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'necessita_vistoria' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'vistoriado_por' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'vistoriado_em' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'liberado_por' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'liberado_em' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'comentario' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'documento_transporte_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tipo_mapa_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'comissario_id' => ['type' => 'index', 'columns' => ['comissario_id'], 'length' => []],
            'agente_id' => ['type' => 'index', 'columns' => ['agente_id'], 'length' => []],
            'despachante_id' => ['type' => 'index', 'columns' => ['despachante_id'], 'length' => []],
            'documento_transporte_id' => ['type' => 'index', 'columns' => ['documento_transporte_id'], 'length' => []],
            'tipo_mapa_id' => ['type' => 'index', 'columns' => ['tipo_mapa_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'mapas_ibfk_1' => ['type' => 'foreign', 'columns' => ['comissario_id'], 'references' => ['empresas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'mapas_ibfk_2' => ['type' => 'foreign', 'columns' => ['agente_id'], 'references' => ['empresas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'mapas_ibfk_3' => ['type' => 'foreign', 'columns' => ['despachante_id'], 'references' => ['empresas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'mapas_ibfk_4' => ['type' => 'foreign', 'columns' => ['documento_transporte_id'], 'references' => ['documentos_transportes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'mapas_ibfk_5' => ['type' => 'foreign', 'columns' => ['tipo_mapa_id'], 'references' => ['tipo_mapas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'comissario_id' => 1,
                'agente_id' => 1,
                'despachante_id' => 1,
                'madeira' => 'Lorem ipsum dolor sit amet',
                'necessita_vistoria' => 'Lorem ipsum dolor sit amet',
                'vistoriado_por' => 1,
                'vistoriado_em' => '2021-08-02 16:30:24',
                'liberado_por' => 1,
                'liberado_em' => '2021-08-02 16:30:24',
                'comentario' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'documento_transporte_id' => 1,
                'tipo_mapa_id' => 1,
            ],
        ];
        parent::init();
    }
}
