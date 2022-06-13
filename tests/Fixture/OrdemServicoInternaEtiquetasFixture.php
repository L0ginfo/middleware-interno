<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrdemServicoInternaEtiquetasFixture
 */
class OrdemServicoInternaEtiquetasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'ordem_servico_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'qtde_leituras' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'codigo_barras_etiqueta' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'lote_codigo' => ['type' => 'string', 'length' => 15, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'codigo gerado automaticamente pelo sistema na criacao de documentacao de entrada', 'precision' => null, 'fixed' => null],
        'lote_item' => ['type' => 'string', 'length' => 15, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'codigo gerado automaticamente pelo sistema na criacao de documentacao de entrada', 'precision' => null, 'fixed' => null],
        'qtde' => ['type' => 'decimal', 'length' => 18, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'saldo da quantidade daquele item no estoque'],
        'peso' => ['type' => 'decimal', 'length' => 18, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'saldo do peso daquele item no estoque'],
        'm2' => ['type' => 'decimal', 'length' => 18, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'saldo do m2 daquele item no estoque'],
        'm3' => ['type' => 'decimal', 'length' => 18, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'saldo do m3 daquele item no estoque'],
        'lote' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Se o determinado produto e controlado por lote, o campo e preenchido', 'precision' => null, 'fixed' => null],
        'serie' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Se o determinado produto e controlado por serie, o campo e preenchido', 'precision' => null, 'fixed' => null],
        'validade' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Se o determinado produto e controlado por validade, o campo e preenchido', 'precision' => null],
        'unidade_medida_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'endereco_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'empresa_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'produto_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created_at' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'updated_at' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'lote_codigo' => ['type' => 'index', 'columns' => ['lote_codigo'], 'length' => []],
            'lote_item' => ['type' => 'index', 'columns' => ['lote_item'], 'length' => []],
            'lote_codigo_2' => ['type' => 'index', 'columns' => ['lote_codigo', 'lote_item'], 'length' => []],
            'unidade_medida_id' => ['type' => 'index', 'columns' => ['unidade_medida_id'], 'length' => []],
            'endereco_id' => ['type' => 'index', 'columns' => ['endereco_id'], 'length' => []],
            'empresa_id' => ['type' => 'index', 'columns' => ['empresa_id'], 'length' => []],
            'produto_id' => ['type' => 'index', 'columns' => ['produto_id'], 'length' => []],
            'ordem_servico_id' => ['type' => 'index', 'columns' => ['ordem_servico_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'ordem_servico_interna_etiquetas_ibfk_1' => ['type' => 'foreign', 'columns' => ['unidade_medida_id'], 'references' => ['unidade_medidas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'ordem_servico_interna_etiquetas_ibfk_2' => ['type' => 'foreign', 'columns' => ['endereco_id'], 'references' => ['enderecos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'ordem_servico_interna_etiquetas_ibfk_3' => ['type' => 'foreign', 'columns' => ['empresa_id'], 'references' => ['empresas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'ordem_servico_interna_etiquetas_ibfk_4' => ['type' => 'foreign', 'columns' => ['produto_id'], 'references' => ['produtos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'ordem_servico_interna_etiquetas_ibfk_5' => ['type' => 'foreign', 'columns' => ['ordem_servico_id'], 'references' => ['ordem_servicos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'ordem_servico_id' => 1,
                'qtde_leituras' => 1,
                'codigo_barras_etiqueta' => 'Lorem ipsum dolor sit amet',
                'lote_codigo' => 'Lorem ipsum d',
                'lote_item' => 'Lorem ipsum d',
                'qtde' => 1.5,
                'peso' => 1.5,
                'm2' => 1.5,
                'm3' => 1.5,
                'lote' => 'Lorem ipsum dolor sit amet',
                'serie' => 'Lorem ipsum dolor sit amet',
                'validade' => '2020-05-28 11:50:31',
                'unidade_medida_id' => 1,
                'endereco_id' => 1,
                'empresa_id' => 1,
                'produto_id' => 1,
                'created_at' => 1590677431,
                'updated_at' => 1590677431,
            ],
        ];
        parent::init();
    }
}
