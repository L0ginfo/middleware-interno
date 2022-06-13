<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ItensFixture
 *
 */
class ItensFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'ncm' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'ncm_descricao' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'descricao' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'codigo' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'codigo_referencia' => ['type' => 'string', 'length' => 40, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'descricao_produto' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'peso_liquido' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'peso_bruto' => ['type' => 'decimal', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'quantidade' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'embalagem_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'codigo_onu_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'container_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'lote_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'embalagem_pk' => ['type' => 'index', 'columns' => ['embalagem_id'], 'length' => []],
            'codigo_onu_pk' => ['type' => 'index', 'columns' => ['codigo_onu_id'], 'length' => []],
            'container_pk' => ['type' => 'index', 'columns' => ['container_id'], 'length' => []],
            'lote_id' => ['type' => 'index', 'columns' => ['lote_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'itens_ibfk_1' => ['type' => 'foreign', 'columns' => ['embalagem_id'], 'references' => ['embalagens', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'itens_ibfk_2' => ['type' => 'foreign', 'columns' => ['codigo_onu_id'], 'references' => ['codigo_onus', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'itens_ibfk_3' => ['type' => 'foreign', 'columns' => ['container_id'], 'references' => ['containers', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'itens_ibfk_4' => ['type' => 'foreign', 'columns' => ['lote_id'], 'references' => ['lotes', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
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
            'ncm' => 'Lorem ipsum dolor sit amet',
            'ncm_descricao' => 'Lorem ipsum dolor sit amet',
            'descricao' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'codigo' => 'Lorem ipsum dolor sit amet',
            'codigo_referencia' => 'Lorem ipsum dolor sit amet',
            'descricao_produto' => 'Lorem ipsum dolor sit amet',
            'peso_liquido' => 1.5,
            'peso_bruto' => 1.5,
            'quantidade' => 1,
            'embalagem_id' => 1,
            'codigo_onu_id' => 1,
            'container_id' => 1,
            'lote_id' => 1
        ],
    ];
}
