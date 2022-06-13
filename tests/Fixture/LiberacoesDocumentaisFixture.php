<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LiberacoesDocumentaisFixture
 */
class LiberacoesDocumentaisFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'nome' => ['type' => 'string', 'length' => 70, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'numero_documento_liberacao' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'numero' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'data_registro' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'data_desembaraco' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'quantidade_adicoes' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'valor_fob_moeda' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'valor_frete_moeda' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'valor_seguro_moeda' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'valor_cif_moeda' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'quantidade_total' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'peso_bruto' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'peso_liquido' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'observacao' => ['type' => 'text', 'length' => 4294967295, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'empresa_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'cliente_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tipo_documento_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'moeda_fob_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'moeda_frete_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'moeda_seguro_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'moeda_cif_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'canal_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'regime_aduaneiro_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'aftn_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tipo_documento_liberacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'empresa_id' => ['type' => 'index', 'columns' => ['empresa_id'], 'length' => []],
            'cliente_id' => ['type' => 'index', 'columns' => ['cliente_id'], 'length' => []],
            'tipo_documento_id' => ['type' => 'index', 'columns' => ['tipo_documento_id'], 'length' => []],
            'moeda_fob_id' => ['type' => 'index', 'columns' => ['moeda_fob_id'], 'length' => []],
            'moeda_frete_id' => ['type' => 'index', 'columns' => ['moeda_frete_id'], 'length' => []],
            'moeda_seguro_id' => ['type' => 'index', 'columns' => ['moeda_seguro_id'], 'length' => []],
            'moeda_cif_id' => ['type' => 'index', 'columns' => ['moeda_cif_id'], 'length' => []],
            'canal_id' => ['type' => 'index', 'columns' => ['canal_id'], 'length' => []],
            'regime_aduaneiro_id' => ['type' => 'index', 'columns' => ['regime_aduaneiro_id'], 'length' => []],
            'aftn_id' => ['type' => 'index', 'columns' => ['aftn_id'], 'length' => []],
            'tipo_documento_liberacao_id' => ['type' => 'index', 'columns' => ['tipo_documento_liberacao_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'liberacoes_documentais_ibfk_1' => ['type' => 'foreign', 'columns' => ['empresa_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'liberacoes_documentais_ibfk_10' => ['type' => 'foreign', 'columns' => ['aftn_id'], 'references' => ['aftns', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'liberacoes_documentais_ibfk_11' => ['type' => 'foreign', 'columns' => ['tipo_documento_liberacao_id'], 'references' => ['tipo_documentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'liberacoes_documentais_ibfk_2' => ['type' => 'foreign', 'columns' => ['cliente_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'liberacoes_documentais_ibfk_3' => ['type' => 'foreign', 'columns' => ['tipo_documento_id'], 'references' => ['tipo_documentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'liberacoes_documentais_ibfk_4' => ['type' => 'foreign', 'columns' => ['moeda_fob_id'], 'references' => ['moedas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'liberacoes_documentais_ibfk_5' => ['type' => 'foreign', 'columns' => ['moeda_frete_id'], 'references' => ['moedas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'liberacoes_documentais_ibfk_6' => ['type' => 'foreign', 'columns' => ['moeda_seguro_id'], 'references' => ['moedas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'liberacoes_documentais_ibfk_7' => ['type' => 'foreign', 'columns' => ['moeda_cif_id'], 'references' => ['moedas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'liberacoes_documentais_ibfk_8' => ['type' => 'foreign', 'columns' => ['canal_id'], 'references' => ['canais', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'liberacoes_documentais_ibfk_9' => ['type' => 'foreign', 'columns' => ['regime_aduaneiro_id'], 'references' => ['regimes_aduaneiros', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'nome' => 'Lorem ipsum dolor sit amet',
                'numero_documento_liberacao' => 'Lorem ipsum dolor sit amet',
                'numero' => 'Lorem ipsum dolor sit amet',
                'data_registro' => '2019-10-22 11:25:33',
                'data_desembaraco' => '2019-10-22 11:25:33',
                'quantidade_adicoes' => 1,
                'valor_fob_moeda' => 1.5,
                'valor_frete_moeda' => 1.5,
                'valor_seguro_moeda' => 1.5,
                'valor_cif_moeda' => 1.5,
                'quantidade_total' => 1.5,
                'peso_bruto' => 1.5,
                'peso_liquido' => 1.5,
                'observacao' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'empresa_id' => 1,
                'cliente_id' => 1,
                'tipo_documento_id' => 1,
                'moeda_fob_id' => 1,
                'moeda_frete_id' => 1,
                'moeda_seguro_id' => 1,
                'moeda_cif_id' => 1,
                'canal_id' => 1,
                'regime_aduaneiro_id' => 1,
                'aftn_id' => 1,
                'tipo_documento_liberacao_id' => 1
            ],
        ];
        parent::init();
    }
}
