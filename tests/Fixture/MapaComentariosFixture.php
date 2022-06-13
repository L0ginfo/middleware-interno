<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MapaComentariosFixture
 */
class MapaComentariosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'comentario' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'mapa_comentario_tipo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'mapa_comentario_acao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'mapa_comentario_tipo_id' => ['type' => 'index', 'columns' => ['mapa_comentario_tipo_id'], 'length' => []],
            'mapa_comentario_acao_id' => ['type' => 'index', 'columns' => ['mapa_comentario_acao_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'mapa_comentarios_ibfk_1' => ['type' => 'foreign', 'columns' => ['mapa_comentario_tipo_id'], 'references' => ['mapa_comentario_tipos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'mapa_comentarios_ibfk_2' => ['type' => 'foreign', 'columns' => ['mapa_comentario_acao_id'], 'references' => ['mapa_comentario_acoes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'comentario' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'mapa_comentario_tipo_id' => 1,
                'mapa_comentario_acao_id' => 1,
            ],
        ];
        parent::init();
    }
}
