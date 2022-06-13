<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ContainerEntradasFixture
 */
class ContainerEntradasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'documento_transporte_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'container_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'free_time_demurrage' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'documento_transporte_id' => ['type' => 'index', 'columns' => ['documento_transporte_id'], 'length' => []],
            'container_id' => ['type' => 'index', 'columns' => ['container_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'container_entradas_ibfk_1' => ['type' => 'foreign', 'columns' => ['documento_transporte_id'], 'references' => ['documentos_transportes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'container_entradas_ibfk_2' => ['type' => 'foreign', 'columns' => ['container_id'], 'references' => ['containers', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'documento_transporte_id' => 1,
                'container_id' => 1,
                'free_time_demurrage' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
