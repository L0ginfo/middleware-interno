<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LiberacaoDocumentalDecisaoTabelaPrecoAdicoesFixture
 */
class LiberacaoDocumentalDecisaoTabelaPrecoAdicoesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'numero' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'liberacao_documental_decisao_tabela_preco_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'liberacao_documental_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'regime_aduaneiro_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'incoterm_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'moeda_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ncm_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'vcmv' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => '0.000000', 'comment' => ''],
        'peso_liquido' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => '0.000000', 'comment' => ''],
        'reimportacao' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'insento' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'liberacao_documental_decisao_tabela_preco_id' => ['type' => 'index', 'columns' => ['liberacao_documental_decisao_tabela_preco_id'], 'length' => []],
            'liberacao_documental_id' => ['type' => 'index', 'columns' => ['liberacao_documental_id'], 'length' => []],
            'regime_aduaneiro_id' => ['type' => 'index', 'columns' => ['regime_aduaneiro_id'], 'length' => []],
            'incoterm_id' => ['type' => 'index', 'columns' => ['incoterm_id'], 'length' => []],
            'moeda_id' => ['type' => 'index', 'columns' => ['moeda_id'], 'length' => []],
            'ncm_id' => ['type' => 'index', 'columns' => ['ncm_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'liberacao_documental_decisao_tabela_preco_adicoes_ibfk_1' => ['type' => 'foreign', 'columns' => ['liberacao_documental_decisao_tabela_preco_id'], 'references' => ['liberacao_documental_decisao_tabela_precos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'liberacao_documental_decisao_tabela_preco_adicoes_ibfk_2' => ['type' => 'foreign', 'columns' => ['liberacao_documental_id'], 'references' => ['liberacoes_documentais', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'liberacao_documental_decisao_tabela_preco_adicoes_ibfk_3' => ['type' => 'foreign', 'columns' => ['regime_aduaneiro_id'], 'references' => ['regimes_aduaneiros', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'liberacao_documental_decisao_tabela_preco_adicoes_ibfk_4' => ['type' => 'foreign', 'columns' => ['incoterm_id'], 'references' => ['incoterms', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'liberacao_documental_decisao_tabela_preco_adicoes_ibfk_5' => ['type' => 'foreign', 'columns' => ['moeda_id'], 'references' => ['moedas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'liberacao_documental_decisao_tabela_preco_adicoes_ibfk_6' => ['type' => 'foreign', 'columns' => ['ncm_id'], 'references' => ['ncms', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'numero' => 'Lorem ipsum dolor sit amet',
                'liberacao_documental_decisao_tabela_preco_id' => 1,
                'liberacao_documental_id' => 1,
                'regime_aduaneiro_id' => 1,
                'incoterm_id' => 1,
                'moeda_id' => 1,
                'ncm_id' => 1,
                'vcmv' => 1.5,
                'peso_liquido' => 1.5,
                'reimportacao' => 1,
                'insento' => 1,
            ],
        ];
        parent::init();
    }
}
