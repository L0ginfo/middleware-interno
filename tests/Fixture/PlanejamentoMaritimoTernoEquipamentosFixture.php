<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PlanejamentoMaritimoTernoEquipamentosFixture
 */
class PlanejamentoMaritimoTernoEquipamentosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'planejamento_maritimo_terno_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'equipamento_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'planejamento_maritimo_terno_id' => ['type' => 'index', 'columns' => ['planejamento_maritimo_terno_id'], 'length' => []],
            'equipamento_id' => ['type' => 'index', 'columns' => ['equipamento_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'planejamento_maritimo_terno_equipamentos_ibfk_1' => ['type' => 'foreign', 'columns' => ['planejamento_maritimo_terno_id'], 'references' => ['planejamento_maritimo_ternos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'planejamento_maritimo_terno_equipamentos_ibfk_2' => ['type' => 'foreign', 'columns' => ['equipamento_id'], 'references' => ['equipamentos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'planejamento_maritimo_terno_id' => 1,
                'equipamento_id' => 1,
            ],
        ];
        parent::init();
    }
}
