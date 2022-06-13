<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * VistoriaAvariasFixture
 */
class VistoriaAvariasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'vistoria_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'vistoria_item_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'avaria_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'volume' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'peso' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'lacre' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'vistoria_id' => ['type' => 'index', 'columns' => ['vistoria_id'], 'length' => []],
            'vistoria_item_id' => ['type' => 'index', 'columns' => ['vistoria_item_id'], 'length' => []],
            'avaria_id' => ['type' => 'index', 'columns' => ['avaria_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'vistoria_avarias_ibfk_1' => ['type' => 'foreign', 'columns' => ['vistoria_id'], 'references' => ['vistorias', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'vistoria_avarias_ibfk_2' => ['type' => 'foreign', 'columns' => ['vistoria_item_id'], 'references' => ['vistoria_itens', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'vistoria_avarias_ibfk_3' => ['type' => 'foreign', 'columns' => ['avaria_id'], 'references' => ['avarias', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'vistoria_id' => 1,
                'vistoria_item_id' => 1,
                'avaria_id' => 1,
                'volume' => 1.5,
                'peso' => 1.5,
                'lacre' => 1.5,
            ],
        ];
        parent::init();
    }
}
