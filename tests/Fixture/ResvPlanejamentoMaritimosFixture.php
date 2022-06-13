<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ResvPlanejamentoMaritimosFixture
 */
class ResvPlanejamentoMaritimosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'resv_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'planejamento_maritimo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'resv_id' => ['type' => 'index', 'columns' => ['resv_id'], 'length' => []],
            'planejamento_maritimo_id' => ['type' => 'index', 'columns' => ['planejamento_maritimo_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'resv_planejamento_maritimos_ibfk_1' => ['type' => 'foreign', 'columns' => ['resv_id'], 'references' => ['resvs', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'resv_planejamento_maritimos_ibfk_2' => ['type' => 'foreign', 'columns' => ['planejamento_maritimo_id'], 'references' => ['planejamento_maritimos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'resv_id' => 1,
                'planejamento_maritimo_id' => 1,
            ],
        ];
        parent::init();
    }
}
