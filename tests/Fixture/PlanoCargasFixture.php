<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PlanoCargasFixture
 */
class PlanoCargasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'planejamento_maritimo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'unidade_medida_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'sentido_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tipo_mercadoria_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'emissao' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'planejamento_maritimo_id' => ['type' => 'index', 'columns' => ['planejamento_maritimo_id'], 'length' => []],
            'unidade_medida_id' => ['type' => 'index', 'columns' => ['unidade_medida_id'], 'length' => []],
            'sentido_id' => ['type' => 'index', 'columns' => ['sentido_id'], 'length' => []],
            'tipo_mercadoria_id' => ['type' => 'index', 'columns' => ['tipo_mercadoria_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'plano_cargas_ibfk_1' => ['type' => 'foreign', 'columns' => ['planejamento_maritimo_id'], 'references' => ['planejamento_maritimos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'plano_cargas_ibfk_2' => ['type' => 'foreign', 'columns' => ['unidade_medida_id'], 'references' => ['unidade_medidas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'plano_cargas_ibfk_3' => ['type' => 'foreign', 'columns' => ['sentido_id'], 'references' => ['sentidos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'plano_cargas_ibfk_4' => ['type' => 'foreign', 'columns' => ['tipo_mercadoria_id'], 'references' => ['tipo_mercadorias', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'planejamento_maritimo_id' => 1,
                'unidade_medida_id' => 1,
                'sentido_id' => 1,
                'tipo_mercadoria_id' => 1,
                'emissao' => '2020-08-07',
            ],
        ];
        parent::init();
    }
}
