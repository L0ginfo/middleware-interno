<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PlanoCargaCaracteristicasFixture
 */
class PlanoCargaCaracteristicasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'plano_carga_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'caracteristica_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'plano_carga_id' => ['type' => 'index', 'columns' => ['plano_carga_id'], 'length' => []],
            'caracteristica_id' => ['type' => 'index', 'columns' => ['caracteristica_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'plano_carga_caracteristicas_ibfk_1' => ['type' => 'foreign', 'columns' => ['plano_carga_id'], 'references' => ['plano_cargas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'plano_carga_caracteristicas_ibfk_2' => ['type' => 'foreign', 'columns' => ['caracteristica_id'], 'references' => ['caracteristicas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'plano_carga_id' => 1,
                'caracteristica_id' => 1,
            ],
        ];
        parent::init();
    }
}
