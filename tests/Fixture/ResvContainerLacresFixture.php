<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ResvContainerLacresFixture
 */
class ResvContainerLacresFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'lacre_numero' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'lacre_tipo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'resv_container_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'lacre_tipo_id' => ['type' => 'index', 'columns' => ['lacre_tipo_id'], 'length' => []],
            'resv_container_id' => ['type' => 'index', 'columns' => ['resv_container_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'resv_container_lacres_ibfk_1' => ['type' => 'foreign', 'columns' => ['lacre_tipo_id'], 'references' => ['lacre_tipos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'resv_container_lacres_ibfk_2' => ['type' => 'foreign', 'columns' => ['resv_container_id'], 'references' => ['resvs_containers', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'lacre_numero' => 'Lorem ipsum dolor sit amet',
                'lacre_tipo_id' => 1,
                'resv_container_id' => 1,
            ],
        ];
        parent::init();
    }
}
