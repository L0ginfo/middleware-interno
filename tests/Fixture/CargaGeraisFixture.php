<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CargaGeraisFixture
 *
 */
class CargaGeraisFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'descricao_mercadoria' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'ncm' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'quantidade' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'peso_bruto' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'peso_liquido' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'codigo_onu_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'embalagem_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'lote_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_carga_gerais_codigo_onus1_idx' => ['type' => 'index', 'columns' => ['codigo_onu_id'], 'length' => []],
            'fk_carga_gerais_embalagens1_idx' => ['type' => 'index', 'columns' => ['embalagem_id'], 'length' => []],
            'fk_carga_gerais_lote1_idx' => ['type' => 'index', 'columns' => ['lote_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'carga_gerais_ibfk_1' => ['type' => 'foreign', 'columns' => ['lote_id'], 'references' => ['lotes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_carga_gerais_codigo_onus1' => ['type' => 'foreign', 'columns' => ['codigo_onu_id'], 'references' => ['codigo_onus', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_carga_gerais_embalagens1' => ['type' => 'foreign', 'columns' => ['embalagem_id'], 'references' => ['embalagens', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'descricao_mercadoria' => 'Lorem ipsum dolor sit amet',
            'ncm' => 'Lorem ipsum dolor sit amet',
            'quantidade' => 1,
            'peso_bruto' => 1,
            'peso_liquido' => 1,
            'codigo_onu_id' => 1,
            'embalagem_id' => 1,
            'lote_id' => 1
        ],
    ];
}
