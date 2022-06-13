<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProdutosFixture
 */
class ProdutosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'descricao' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'codigo' => ['type' => 'string', 'length' => 15, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'ncm_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'empresa_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'unidade_medida_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'is_controlado_validade' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'is_usado_fifo' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'controla_serie' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'depositante_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'sku' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'produto_classificacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'controla_lote' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'codigo_barras' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'c20_empresa_id_empresas' => ['type' => 'index', 'columns' => ['empresa_id'], 'length' => []],
            'c21_unidade_medida_id_unidade_medidas' => ['type' => 'index', 'columns' => ['unidade_medida_id'], 'length' => []],
            'c22_ncm_id_ncms' => ['type' => 'index', 'columns' => ['ncm_id'], 'length' => []],
            'depositante_id' => ['type' => 'index', 'columns' => ['depositante_id'], 'length' => []],
            'produto_classificacao_id' => ['type' => 'index', 'columns' => ['produto_classificacao_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'c20_empresa_id_empresas' => ['type' => 'foreign', 'columns' => ['empresa_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'c21_unidade_medida_id_unidade_medidas' => ['type' => 'foreign', 'columns' => ['unidade_medida_id'], 'references' => ['unidade_medidas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'c22_ncm_id_ncms' => ['type' => 'foreign', 'columns' => ['ncm_id'], 'references' => ['ncms', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'produtos_ibfk_1' => ['type' => 'foreign', 'columns' => ['depositante_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'produtos_ibfk_2' => ['type' => 'foreign', 'columns' => ['produto_classificacao_id'], 'references' => ['produto_classificacoes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'descricao' => 'Lorem ipsum dolor sit amet',
                'codigo' => 'Lorem ipsum d',
                'ncm_id' => 1,
                'empresa_id' => 1,
                'unidade_medida_id' => 1,
                'is_controlado_validade' => 1,
                'is_usado_fifo' => 1,
                'controla_serie' => 1,
                'depositante_id' => 1,
                'sku' => 'Lorem ipsum dolor sit amet',
                'produto_classificacao_id' => 1,
                'controla_lote' => 1,
                'codigo_barras' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
