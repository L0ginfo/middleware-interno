<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LotesFixture
 *
 */
class LotesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'tipo_conhecimento_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'conhecimento' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'data_conhecimento' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'ce_mercante' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'referencia_cliente' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'moeda_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'valor_cif' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'valor_fob' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'valor_frete' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'valor_seguro' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'familia_codigo' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'pais_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'moeda_id' => ['type' => 'index', 'columns' => ['moeda_id'], 'length' => []],
            'tipo_conhecimento_id' => ['type' => 'index', 'columns' => ['tipo_conhecimento_id'], 'length' => []],
            'pais_id' => ['type' => 'index', 'columns' => ['pais_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'Fk_lotes_moedas' => ['type' => 'foreign', 'columns' => ['moeda_id'], 'references' => ['moedas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_lotes_pais' => ['type' => 'foreign', 'columns' => ['pais_id'], 'references' => ['paises', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'lotes_ibfk_1' => ['type' => 'foreign', 'columns' => ['tipo_conhecimento_id'], 'references' => ['tipo_conhecimentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'tipo_conhecimento_id' => 1,
            'conhecimento' => 'Lorem ipsum dolor sit amet',
            'data_conhecimento' => '2016-09-07',
            'ce_mercante' => 'Lorem ipsum dolor sit amet',
            'referencia_cliente' => 'Lorem ipsum dolor sit amet',
            'moeda_id' => 1,
            'valor_cif' => 'Lorem ipsum dolor ',
            'valor_fob' => 'Lorem ipsum dolor ',
            'valor_frete' => 'Lorem ipsum dolor ',
            'valor_seguro' => 'Lorem ipsum dolor ',
            'familia_codigo' => 'Lorem ip',
            'pais_id' => 1
        ],
    ];
}
