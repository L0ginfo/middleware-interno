<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProdutoEstruturasFixture
 */
class ProdutoEstruturasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'produto_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'unidade_medida_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'produto_componente_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'unidade_medida_comp_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'quantidade' => ['type' => 'decimal', 'length' => 10, 'precision' => 0, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'produto_id' => ['type' => 'index', 'columns' => ['produto_id'], 'length' => []],
            'produto_componente_id' => ['type' => 'index', 'columns' => ['produto_componente_id'], 'length' => []],
            'unidade_medida_id' => ['type' => 'index', 'columns' => ['unidade_medida_id'], 'length' => []],
            'unidade_medida_comp_id' => ['type' => 'index', 'columns' => ['unidade_medida_comp_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'produto_estruturas_ibfk_1' => ['type' => 'foreign', 'columns' => ['produto_id'], 'references' => ['produtos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'produto_estruturas_ibfk_2' => ['type' => 'foreign', 'columns' => ['produto_componente_id'], 'references' => ['produtos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'produto_estruturas_ibfk_3' => ['type' => 'foreign', 'columns' => ['unidade_medida_id'], 'references' => ['unidade_medidas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'produto_estruturas_ibfk_4' => ['type' => 'foreign', 'columns' => ['unidade_medida_comp_id'], 'references' => ['unidade_medidas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'produto_id' => 1,
                'unidade_medida_id' => 1,
                'produto_componente_id' => 1,
                'unidade_medida_comp_id' => 1,
                'quantidade' => 1.5,
            ],
        ];
        parent::init();
    }
}
