<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentosMercadoriasFixture
 */
class DocumentosMercadoriasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'numero_documento' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'data_emissao' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'lote_codigo' => ['type' => 'string', 'length' => 15, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'valor_cif_moeda' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'valor_cif_real' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'peso_liquido' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'peso_bruto' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'data_vencimento_regime' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'valor_frete_moeda' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'valor_seguro_moeda' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'm3' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'numero_voo' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'volume' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'modal_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'cliente_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'despachante_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'agente_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'parceiro_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'regimes_aduaneiro_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'moeda_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'documento_mercadoria_id_master' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'documento_transporte_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'pais_origem_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'moeda_frete_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'moeda_seguro_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'natureza_carga_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tratamento_carga_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tipo_documento_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'empresa_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'modal_id' => ['type' => 'index', 'columns' => ['modal_id'], 'length' => []],
            'cliente_id' => ['type' => 'index', 'columns' => ['cliente_id'], 'length' => []],
            'despachante_id' => ['type' => 'index', 'columns' => ['despachante_id'], 'length' => []],
            'agente_id' => ['type' => 'index', 'columns' => ['agente_id'], 'length' => []],
            'parceiro_id' => ['type' => 'index', 'columns' => ['parceiro_id'], 'length' => []],
            'regimes_aduaneiro_id' => ['type' => 'index', 'columns' => ['regimes_aduaneiro_id'], 'length' => []],
            'moeda_id' => ['type' => 'index', 'columns' => ['moeda_id'], 'length' => []],
            'documento_mercadoria_id_master' => ['type' => 'index', 'columns' => ['documento_mercadoria_id_master'], 'length' => []],
            'documento_transporte_id' => ['type' => 'index', 'columns' => ['documento_transporte_id'], 'length' => []],
            'pais_origem_id' => ['type' => 'index', 'columns' => ['pais_origem_id'], 'length' => []],
            'moeda_frete_id' => ['type' => 'index', 'columns' => ['moeda_frete_id'], 'length' => []],
            'moeda_seguro_id' => ['type' => 'index', 'columns' => ['moeda_seguro_id'], 'length' => []],
            'natureza_carga_id' => ['type' => 'index', 'columns' => ['natureza_carga_id'], 'length' => []],
            'tratamento_carga_id' => ['type' => 'index', 'columns' => ['tratamento_carga_id'], 'length' => []],
            'tipo_documento_id' => ['type' => 'index', 'columns' => ['tipo_documento_id'], 'length' => []],
            'empresa_id' => ['type' => 'index', 'columns' => ['empresa_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'documentos_mercadorias_ibfk_1' => ['type' => 'foreign', 'columns' => ['modal_id'], 'references' => ['modais', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'documentos_mercadorias_ibfk_10' => ['type' => 'foreign', 'columns' => ['pais_origem_id'], 'references' => ['pais', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'documentos_mercadorias_ibfk_11' => ['type' => 'foreign', 'columns' => ['moeda_frete_id'], 'references' => ['moedas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'documentos_mercadorias_ibfk_12' => ['type' => 'foreign', 'columns' => ['moeda_seguro_id'], 'references' => ['moedas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'documentos_mercadorias_ibfk_13' => ['type' => 'foreign', 'columns' => ['natureza_carga_id'], 'references' => ['naturezas_cargas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'documentos_mercadorias_ibfk_14' => ['type' => 'foreign', 'columns' => ['tratamento_carga_id'], 'references' => ['tratamentos_cargas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'documentos_mercadorias_ibfk_15' => ['type' => 'foreign', 'columns' => ['tipo_documento_id'], 'references' => ['tipo_documentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'documentos_mercadorias_ibfk_16' => ['type' => 'foreign', 'columns' => ['empresa_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'documentos_mercadorias_ibfk_2' => ['type' => 'foreign', 'columns' => ['cliente_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'documentos_mercadorias_ibfk_3' => ['type' => 'foreign', 'columns' => ['despachante_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'documentos_mercadorias_ibfk_4' => ['type' => 'foreign', 'columns' => ['agente_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'documentos_mercadorias_ibfk_5' => ['type' => 'foreign', 'columns' => ['parceiro_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'documentos_mercadorias_ibfk_6' => ['type' => 'foreign', 'columns' => ['regimes_aduaneiro_id'], 'references' => ['regimes_aduaneiros', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'documentos_mercadorias_ibfk_7' => ['type' => 'foreign', 'columns' => ['moeda_id'], 'references' => ['moedas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'documentos_mercadorias_ibfk_8' => ['type' => 'foreign', 'columns' => ['documento_mercadoria_id_master'], 'references' => ['documentos_mercadorias', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'documentos_mercadorias_ibfk_9' => ['type' => 'foreign', 'columns' => ['documento_transporte_id'], 'references' => ['documentos_transportes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'numero_documento' => 'Lorem ipsum dolor sit amet',
                'data_emissao' => '2019-09-23',
                'lote_codigo' => 'Lorem ipsum d',
                'valor_cif_moeda' => 1.5,
                'valor_cif_real' => 1.5,
                'peso_liquido' => 1.5,
                'peso_bruto' => 1.5,
                'data_vencimento_regime' => '2019-09-23',
                'valor_frete_moeda' => 1.5,
                'valor_seguro_moeda' => 1.5,
                'm3' => 1.5,
                'numero_voo' => 'Lorem ipsum dolor ',
                'volume' => 1,
                'modal_id' => 1,
                'cliente_id' => 1,
                'despachante_id' => 1,
                'agente_id' => 1,
                'parceiro_id' => 1,
                'regimes_aduaneiro_id' => 1,
                'moeda_id' => 1,
                'documento_mercadoria_id_master' => 1,
                'documento_transporte_id' => 1,
                'pais_origem_id' => 1,
                'moeda_frete_id' => 1,
                'moeda_seguro_id' => 1,
                'natureza_carga_id' => 1,
                'tratamento_carga_id' => 1,
                'tipo_documento_id' => 1,
                'empresa_id' => 1
            ],
        ];
        parent::init();
    }
}
