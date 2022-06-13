<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProgramacaoResvMaritimasFixture
 */
class ProgramacaoResvMaritimasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'navio_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'programacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'navio_id' => ['type' => 'index', 'columns' => ['navio_id'], 'length' => []],
            'programacao_id' => ['type' => 'index', 'columns' => ['programacao_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'programacao_resv_maritimas_ibfk_1' => ['type' => 'foreign', 'columns' => ['navio_id'], 'references' => ['veiculos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'programacao_resv_maritimas_ibfk_2' => ['type' => 'foreign', 'columns' => ['programacao_id'], 'references' => ['programacoes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'navio_id' => 1,
                'programacao_id' => 1,
            ],
        ];
        parent::init();
    }
}
