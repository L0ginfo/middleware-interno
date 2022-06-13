<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RequerimentosFixture
 *
 */
class RequerimentosFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'bl_awb' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'cnpj_cliente' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'numero_documento' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'data_emissao' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'ce_mercante' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'cnpj_representante' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'valor_cif' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'referencia_cliente' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'observacoes' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'empresa_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'moeda_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'pais_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'documento_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'navio_viagem_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_requerimentos_empresas1_idx' => ['type' => 'index', 'columns' => ['empresa_id'], 'length' => []],
            'fk_requerimentos_moedas1_idx' => ['type' => 'index', 'columns' => ['moeda_id'], 'length' => []],
            'fk_requerimentos_paises1_idx' => ['type' => 'index', 'columns' => ['pais_id'], 'length' => []],
            'fk_requerimentos_documentos1_idx' => ['type' => 'index', 'columns' => ['documento_id'], 'length' => []],
            'fk_requerimentos_navio_viagens1_idx' => ['type' => 'index', 'columns' => ['navio_viagem_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_requerimentos_empresas1' => ['type' => 'foreign', 'columns' => ['empresa_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_requerimentos_moedas1' => ['type' => 'foreign', 'columns' => ['moeda_id'], 'references' => ['moedas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_requerimentos_paises1' => ['type' => 'foreign', 'columns' => ['pais_id'], 'references' => ['paises', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_requerimentos_documentos1' => ['type' => 'foreign', 'columns' => ['documento_id'], 'references' => ['documentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_requerimentos_navio_viagens1' => ['type' => 'foreign', 'columns' => ['navio_viagem_id'], 'references' => ['navio_viagens', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'bl_awb' => 'Lorem ipsum dolor sit amet',
            'cnpj_cliente' => 'Lorem ipsum dolor sit amet',
            'numero_documento' => 'Lorem ipsum dolor sit amet',
            'data_emissao' => '2016-05-03 11:15:12',
            'ce_mercante' => 'Lorem ipsum dolor sit amet',
            'cnpj_representante' => 'Lorem ipsum dolor sit amet',
            'valor_cif' => 1,
            'referencia_cliente' => 'Lorem ipsum dolor sit amet',
            'observacoes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'empresa_id' => 1,
            'moeda_id' => 1,
            'pais_id' => 1,
            'documento_id' => 1,
            'navio_viagem_id' => 1
        ],
    ];
}
