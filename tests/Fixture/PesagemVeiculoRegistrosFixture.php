<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PesagemVeiculoRegistrosFixture
 */
class PesagemVeiculoRegistrosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'peso' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'manual' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'balanca_codigo' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'balanca_id' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'pesagem_veiculo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'pesagem_tipo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'pesagem_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created_at' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'updated_at' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'pesagem_veiculo_id' => ['type' => 'index', 'columns' => ['pesagem_veiculo_id'], 'length' => []],
            'pesagem_tipo_id' => ['type' => 'index', 'columns' => ['pesagem_tipo_id'], 'length' => []],
            'pesagem_id' => ['type' => 'index', 'columns' => ['pesagem_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'pesagem_veiculo_registros_ibfk_1' => ['type' => 'foreign', 'columns' => ['pesagem_veiculo_id'], 'references' => ['pesagem_veiculos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'pesagem_veiculo_registros_ibfk_2' => ['type' => 'foreign', 'columns' => ['pesagem_tipo_id'], 'references' => ['pesagem_tipos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'pesagem_veiculo_registros_ibfk_3' => ['type' => 'foreign', 'columns' => ['pesagem_id'], 'references' => ['pesagens', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'peso' => 1.5,
                'manual' => 1,
                'balanca_codigo' => 'Lorem ipsum dolor sit amet',
                'balanca_id' => 'Lorem ipsum dolor sit amet',
                'pesagem_veiculo_id' => 1,
                'pesagem_tipo_id' => 1,
                'pesagem_id' => 1,
                'created_at' => 1603825182,
                'updated_at' => 1603825182,
            ],
        ];
        parent::init();
    }
}
