<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentoRegimeEspeciaisFixture
 */
class DocumentoRegimeEspeciaisFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'numero_documento_especial' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'numero' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'data_registro' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'data_desembaraco' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'quantidade_adicoes' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'valor_fob_moeda' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'valor_frete_moeda' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'valor_seguro_moeda' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'valor_cif_moeda' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'quantidade_total' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'peso_bruto' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'peso_liquido' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'observacao' => ['type' => 'text', 'length' => 4294967295, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
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
        'tipo_documento_especial_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'pessoa_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created_at' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'updated_at' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'libera_por_transportadora' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'empresa_id' => ['type' => 'index', 'columns' => ['empresa_id'], 'length' => []],
            'cliente_id' => ['type' => 'index', 'columns' => ['cliente_id'], 'length' => []],
            'tipo_documento_especial_id' => ['type' => 'index', 'columns' => ['tipo_documento_especial_id'], 'length' => []],
            'tipo_documento_id' => ['type' => 'index', 'columns' => ['tipo_documento_id'], 'length' => []],
            'moeda_fob_id' => ['type' => 'index', 'columns' => ['moeda_fob_id'], 'length' => []],
            'moeda_frete_id' => ['type' => 'index', 'columns' => ['moeda_frete_id'], 'length' => []],
            'moeda_seguro_id' => ['type' => 'index', 'columns' => ['moeda_seguro_id'], 'length' => []],
            'moeda_cif_id' => ['type' => 'index', 'columns' => ['moeda_cif_id'], 'length' => []],
            'canal_id' => ['type' => 'index', 'columns' => ['canal_id'], 'length' => []],
            'regime_aduaneiro_id' => ['type' => 'index', 'columns' => ['regime_aduaneiro_id'], 'length' => []],
            'aftn_id' => ['type' => 'index', 'columns' => ['aftn_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'documento_regime_especiais_ibfk_1' => ['type' => 'foreign', 'columns' => ['empresa_id'], 'references' => ['empresas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'documento_regime_especiais_ibfk_10' => ['type' => 'foreign', 'columns' => ['regime_aduaneiro_id'], 'references' => ['regimes_aduaneiros', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'documento_regime_especiais_ibfk_11' => ['type' => 'foreign', 'columns' => ['aftn_id'], 'references' => ['aftns', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'documento_regime_especiais_ibfk_2' => ['type' => 'foreign', 'columns' => ['cliente_id'], 'references' => ['empresas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'documento_regime_especiais_ibfk_3' => ['type' => 'foreign', 'columns' => ['tipo_documento_especial_id'], 'references' => ['tipo_documentos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'documento_regime_especiais_ibfk_4' => ['type' => 'foreign', 'columns' => ['tipo_documento_id'], 'references' => ['tipo_documentos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'documento_regime_especiais_ibfk_5' => ['type' => 'foreign', 'columns' => ['moeda_fob_id'], 'references' => ['moedas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'documento_regime_especiais_ibfk_6' => ['type' => 'foreign', 'columns' => ['moeda_frete_id'], 'references' => ['moedas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'documento_regime_especiais_ibfk_7' => ['type' => 'foreign', 'columns' => ['moeda_seguro_id'], 'references' => ['moedas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'documento_regime_especiais_ibfk_8' => ['type' => 'foreign', 'columns' => ['moeda_cif_id'], 'references' => ['moedas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'documento_regime_especiais_ibfk_9' => ['type' => 'foreign', 'columns' => ['canal_id'], 'references' => ['canais', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'numero_documento_especial' => 'Lorem ipsum dolor sit amet',
                'numero' => 'Lorem ipsum dolor sit amet',
                'data_registro' => '2021-04-26 18:16:35',
                'data_desembaraco' => '2021-04-26 18:16:35',
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
                'tipo_documento_especial_id' => 1,
                'pessoa_id' => 1,
                'created_at' => 1619471795,
                'updated_at' => 1619471795,
                'libera_por_transportadora' => 1,
            ],
        ];
        parent::init();
    }
}
