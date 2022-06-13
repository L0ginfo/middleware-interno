<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrdemServicoDocumentoRegimeEspecialItensFixture
 */
class OrdemServicoDocumentoRegimeEspecialItensFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'lote_codigo' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'lote_item' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'sequencia_item' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'quantidade' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'peso' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'temperatura' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'm2' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'm3' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'ordem_servico_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'documento_regime_especial_adicao_item_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'unidade_medida_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'embalagem_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'produto_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'lote' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Se o determinado produto e controlado por lote, o campo e preenchido', 'precision' => null, 'fixed' => null],
        'serie' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Se o determinado produto e controlado por serie, o campo e preenchido', 'precision' => null, 'fixed' => null],
        'validade' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Se o determinado produto e controlado por validade, o campo e preenchido', 'precision' => null],
        'endereco_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'status_estoque_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'container_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'entrada_saida_container_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'controle_especifico_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'lote_codigo' => ['type' => 'index', 'columns' => ['lote_codigo', 'lote_item'], 'length' => []],
            'lote_codigo_2' => ['type' => 'index', 'columns' => ['lote_codigo'], 'length' => []],
            'ordem_servico_id' => ['type' => 'index', 'columns' => ['ordem_servico_id'], 'length' => []],
            'documento_regime_especial_adicao_item_id' => ['type' => 'index', 'columns' => ['documento_regime_especial_adicao_item_id'], 'length' => []],
            'unidade_medida_id' => ['type' => 'index', 'columns' => ['unidade_medida_id'], 'length' => []],
            'embalagem_id' => ['type' => 'index', 'columns' => ['embalagem_id'], 'length' => []],
            'produto_id' => ['type' => 'index', 'columns' => ['produto_id'], 'length' => []],
            'endereco_id' => ['type' => 'index', 'columns' => ['endereco_id'], 'length' => []],
            'status_estoque_id' => ['type' => 'index', 'columns' => ['status_estoque_id'], 'length' => []],
            'container_id' => ['type' => 'index', 'columns' => ['container_id'], 'length' => []],
            'entrada_saida_container_id' => ['type' => 'index', 'columns' => ['entrada_saida_container_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'ordem_servico_documento_regime_especial_itens_ibfk_1' => ['type' => 'foreign', 'columns' => ['ordem_servico_id'], 'references' => ['ordem_servicos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'ordem_servico_documento_regime_especial_itens_ibfk_10' => ['type' => 'foreign', 'columns' => ['entrada_saida_container_id'], 'references' => ['controle_especificos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'ordem_servico_documento_regime_especial_itens_ibfk_2' => ['type' => 'foreign', 'columns' => ['documento_regime_especial_adicao_item_id'], 'references' => ['documento_regime_especial_adicao_itens', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'ordem_servico_documento_regime_especial_itens_ibfk_3' => ['type' => 'foreign', 'columns' => ['unidade_medida_id'], 'references' => ['unidade_medidas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'ordem_servico_documento_regime_especial_itens_ibfk_4' => ['type' => 'foreign', 'columns' => ['embalagem_id'], 'references' => ['embalagens', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'ordem_servico_documento_regime_especial_itens_ibfk_5' => ['type' => 'foreign', 'columns' => ['produto_id'], 'references' => ['produtos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'ordem_servico_documento_regime_especial_itens_ibfk_6' => ['type' => 'foreign', 'columns' => ['endereco_id'], 'references' => ['enderecos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'ordem_servico_documento_regime_especial_itens_ibfk_7' => ['type' => 'foreign', 'columns' => ['status_estoque_id'], 'references' => ['status_estoques', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'ordem_servico_documento_regime_especial_itens_ibfk_8' => ['type' => 'foreign', 'columns' => ['container_id'], 'references' => ['containers', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'ordem_servico_documento_regime_especial_itens_ibfk_9' => ['type' => 'foreign', 'columns' => ['entrada_saida_container_id'], 'references' => ['entrada_saida_containers', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'lote_codigo' => 'Lorem ipsum dolor sit amet',
                'lote_item' => 'Lorem ipsum dolor sit amet',
                'sequencia_item' => 1,
                'quantidade' => 1.5,
                'peso' => 1.5,
                'temperatura' => 1.5,
                'm2' => 1.5,
                'm3' => 1.5,
                'ordem_servico_id' => 1,
                'documento_regime_especial_adicao_item_id' => 1,
                'unidade_medida_id' => 1,
                'embalagem_id' => 1,
                'produto_id' => 1,
                'lote' => 'Lorem ipsum dolor sit amet',
                'serie' => 'Lorem ipsum dolor sit amet',
                'validade' => '2021-10-11 17:49:06',
                'endereco_id' => 1,
                'status_estoque_id' => 1,
                'container_id' => 1,
                'entrada_saida_container_id' => 1,
                'controle_especifico_id' => 1,
            ],
        ];
        parent::init();
    }
}
