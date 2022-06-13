<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PlanejamentoMaritimoEventoMudancasFixture
 */
class PlanejamentoMaritimoEventoMudancasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'evento_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'planejamento_maritimo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'planejamento_maritimo_mudanca_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'data_hora' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'evento_id' => ['type' => 'index', 'columns' => ['evento_id'], 'length' => []],
            'planejamento_maritimo_id' => ['type' => 'index', 'columns' => ['planejamento_maritimo_id'], 'length' => []],
            'planejamento_maritimo_mudanca_id' => ['type' => 'index', 'columns' => ['planejamento_maritimo_mudanca_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'planejamento_maritimo_evento_mudancas_ibfk_1' => ['type' => 'foreign', 'columns' => ['evento_id'], 'references' => ['eventos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'planejamento_maritimo_evento_mudancas_ibfk_2' => ['type' => 'foreign', 'columns' => ['planejamento_maritimo_id'], 'references' => ['planejamento_maritimos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'planejamento_maritimo_evento_mudancas_ibfk_3' => ['type' => 'foreign', 'columns' => ['planejamento_maritimo_mudanca_id'], 'references' => ['planejamento_maritimo_mudancas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'evento_id' => 1,
                'planejamento_maritimo_id' => 1,
                'planejamento_maritimo_mudanca_id' => 1,
                'data_hora' => '2021-03-10 10:47:47',
            ],
        ];
        parent::init();
    }
}
