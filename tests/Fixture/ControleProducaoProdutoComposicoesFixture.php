<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ControleProducaoProdutoComposicoesFixture
 */
class ControleProducaoProdutoComposicoesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'controle_producao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'produto_composicao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'percentual' => ['type' => 'decimal', 'length' => 18, 'precision' => 3, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'controle_producao_id' => ['type' => 'index', 'columns' => ['controle_producao_id'], 'length' => []],
            'produto_composicao_id' => ['type' => 'index', 'columns' => ['produto_composicao_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'controle_producao_produto_composicoes_ibfk_1' => ['type' => 'foreign', 'columns' => ['controle_producao_id'], 'references' => ['controle_producoes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'controle_producao_produto_composicoes_ibfk_2' => ['type' => 'foreign', 'columns' => ['produto_composicao_id'], 'references' => ['produtos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'controle_producao_id' => 1,
                'produto_composicao_id' => 1,
                'percentual' => 1.5,
            ],
        ];
        parent::init();
    }
}
