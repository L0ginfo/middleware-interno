<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LingadaCaracteristicasFixture
 */
class LingadaCaracteristicasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'plano_carga_caracteristica_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ordem_servico_item_lingada_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'caracteristica_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'plano_carga_caracteristica_porao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'plano_carga_caracteristica_id' => ['type' => 'index', 'columns' => ['plano_carga_caracteristica_id'], 'length' => []],
            'ordem_servico_item_lingada_id' => ['type' => 'index', 'columns' => ['ordem_servico_item_lingada_id'], 'length' => []],
            'caracteristica_id' => ['type' => 'index', 'columns' => ['caracteristica_id'], 'length' => []],
            'plano_carga_caracteristica_porao_id' => ['type' => 'index', 'columns' => ['plano_carga_caracteristica_porao_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'lingada_caracteristicas_ibfk_1' => ['type' => 'foreign', 'columns' => ['plano_carga_caracteristica_id'], 'references' => ['plano_carga_caracteristicas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'lingada_caracteristicas_ibfk_2' => ['type' => 'foreign', 'columns' => ['ordem_servico_item_lingada_id'], 'references' => ['ordem_servico_item_lingadas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'lingada_caracteristicas_ibfk_3' => ['type' => 'foreign', 'columns' => ['caracteristica_id'], 'references' => ['caracteristicas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'lingada_caracteristicas_ibfk_4' => ['type' => 'foreign', 'columns' => ['plano_carga_caracteristica_porao_id'], 'references' => ['plano_carga_porao_caracteristicas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'plano_carga_caracteristica_id' => 1,
                'ordem_servico_item_lingada_id' => 1,
                'caracteristica_id' => 1,
                'plano_carga_caracteristica_porao_id' => 1,
            ],
        ];
        parent::init();
    }
}
