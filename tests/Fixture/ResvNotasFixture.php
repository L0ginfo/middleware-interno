<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ResvNotasFixture
 */
class ResvNotasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'nota_fiscal_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'resv_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'nota_fiscal_id' => ['type' => 'index', 'columns' => ['nota_fiscal_id'], 'length' => []],
            'resv_id' => ['type' => 'index', 'columns' => ['resv_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'resv_notas_ibfk_1' => ['type' => 'foreign', 'columns' => ['nota_fiscal_id'], 'references' => ['nota_fiscais', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'resv_notas_ibfk_2' => ['type' => 'foreign', 'columns' => ['resv_id'], 'references' => ['resvs', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'nota_fiscal_id' => 1,
                'resv_id' => 1,
            ],
        ];
        parent::init();
    }
}
