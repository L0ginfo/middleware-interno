<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PlanejamentoSolicitacaoPesagensFixture
 */
class PlanejamentoSolicitacaoPesagensFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'planejamento_movimentacao_produto_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'data_hora_solicitacao' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'planejamento_movimentacao_produto_id' => ['type' => 'index', 'columns' => ['planejamento_movimentacao_produto_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'planejamento_solicitacao_pesagens_ibfk_1' => ['type' => 'foreign', 'columns' => ['planejamento_movimentacao_produto_id'], 'references' => ['planejamento_movimentacao_produtos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'planejamento_movimentacao_produto_id' => 1,
                'data_hora_solicitacao' => '2021-10-25 09:25:18',
            ],
        ];
        parent::init();
    }
}
