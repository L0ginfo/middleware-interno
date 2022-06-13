<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DriveEspacoContainersFixture
 */
class DriveEspacoContainersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'drive_espaco_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'container_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'drive_espaco_id' => ['type' => 'index', 'columns' => ['drive_espaco_id'], 'length' => []],
            'container_id' => ['type' => 'index', 'columns' => ['container_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'drive_espaco_containers_ibfk_1' => ['type' => 'foreign', 'columns' => ['drive_espaco_id'], 'references' => ['drive_espacos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'drive_espaco_containers_ibfk_2' => ['type' => 'foreign', 'columns' => ['container_id'], 'references' => ['containers', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'drive_espaco_id' => 1,
                'container_id' => 1,
            ],
        ];
        parent::init();
    }
}
