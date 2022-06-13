<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentoRegimeEspecialAdicoesFixture
 */
class DocumentoRegimeEspecialAdicoesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'documento_regime_especial_id' => ['type' => 'integer', 'length' => 15, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'empresa_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'exportador_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'incoterm_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ncm_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'nbm_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'moeda_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'importacao_regime_tributacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'produto_regime_tributacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'pis_cofins_regime_tributacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'peso_liquido' => ['type' => 'float', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => '0.000000', 'comment' => ''],
        'vcmv' => ['type' => 'float', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => '0.000000', 'comment' => ''],
        'importacao_aliquota' => ['type' => 'float', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => '0.000000', 'comment' => ''],
        'importacao_recolher' => ['type' => 'float', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => '0.000000', 'comment' => ''],
        'produto_aliquota' => ['type' => 'float', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => '0.000000', 'comment' => ''],
        'produto_recolher' => ['type' => 'float', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => '0.000000', 'comment' => ''],
        'pis_cofins_percentual' => ['type' => 'float', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => '0.000000', 'comment' => ''],
        'base_calculo' => ['type' => 'float', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => '0.000000', 'comment' => ''],
        'pis_pasep_aloquita' => ['type' => 'float', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => '0.000000', 'comment' => ''],
        'pis_pasep_devido' => ['type' => 'float', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => '0.000000', 'comment' => ''],
        'pis_pasep_recolher' => ['type' => 'float', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => '0.000000', 'comment' => ''],
        'cofins_aloquita' => ['type' => 'float', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => '0.000000', 'comment' => ''],
        'cofins_devido' => ['type' => 'float', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => '0.000000', 'comment' => ''],
        'cofins_recolher' => ['type' => 'float', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => '0.000000', 'comment' => ''],
        'created_at' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'updated_at' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'documento_regime_especial_id' => ['type' => 'index', 'columns' => ['documento_regime_especial_id'], 'length' => []],
            'empresa_id' => ['type' => 'index', 'columns' => ['empresa_id'], 'length' => []],
            'exportador_id' => ['type' => 'index', 'columns' => ['exportador_id'], 'length' => []],
            'incoterm_id' => ['type' => 'index', 'columns' => ['incoterm_id'], 'length' => []],
            'ncm_id' => ['type' => 'index', 'columns' => ['ncm_id'], 'length' => []],
            'nbm_id' => ['type' => 'index', 'columns' => ['nbm_id'], 'length' => []],
            'moeda_id' => ['type' => 'index', 'columns' => ['moeda_id'], 'length' => []],
            'importacao_regime_tributacao_id' => ['type' => 'index', 'columns' => ['importacao_regime_tributacao_id'], 'length' => []],
            'produto_regime_tributacao_id' => ['type' => 'index', 'columns' => ['produto_regime_tributacao_id'], 'length' => []],
            'pis_cofins_regime_tributacao_id' => ['type' => 'index', 'columns' => ['pis_cofins_regime_tributacao_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'documento_regime_especial_adicoes_ibfk_10' => ['type' => 'foreign', 'columns' => ['importacao_regime_tributacao_id'], 'references' => ['regime_tributacoes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'documento_regime_especial_adicoes_ibfk_11' => ['type' => 'foreign', 'columns' => ['produto_regime_tributacao_id'], 'references' => ['regime_tributacoes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'documento_regime_especial_adicoes_ibfk_12' => ['type' => 'foreign', 'columns' => ['pis_cofins_regime_tributacao_id'], 'references' => ['regime_tributacoes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'documento_regime_especial_adicoes_ibfk_3' => ['type' => 'foreign', 'columns' => ['documento_regime_especial_id'], 'references' => ['documento_regime_especiais', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'documento_regime_especial_adicoes_ibfk_4' => ['type' => 'foreign', 'columns' => ['empresa_id'], 'references' => ['empresas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'documento_regime_especial_adicoes_ibfk_5' => ['type' => 'foreign', 'columns' => ['exportador_id'], 'references' => ['empresas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'documento_regime_especial_adicoes_ibfk_6' => ['type' => 'foreign', 'columns' => ['incoterm_id'], 'references' => ['incoterms', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'documento_regime_especial_adicoes_ibfk_7' => ['type' => 'foreign', 'columns' => ['ncm_id'], 'references' => ['ncms', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'documento_regime_especial_adicoes_ibfk_8' => ['type' => 'foreign', 'columns' => ['nbm_id'], 'references' => ['ncms', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'documento_regime_especial_adicoes_ibfk_9' => ['type' => 'foreign', 'columns' => ['moeda_id'], 'references' => ['moedas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'documento_regime_especial_id' => 1,
                'empresa_id' => 1,
                'exportador_id' => 1,
                'incoterm_id' => 1,
                'ncm_id' => 1,
                'nbm_id' => 1,
                'moeda_id' => 1,
                'importacao_regime_tributacao_id' => 1,
                'produto_regime_tributacao_id' => 1,
                'pis_cofins_regime_tributacao_id' => 1,
                'peso_liquido' => 1,
                'vcmv' => 1,
                'importacao_aliquota' => 1,
                'importacao_recolher' => 1,
                'produto_aliquota' => 1,
                'produto_recolher' => 1,
                'pis_cofins_percentual' => 1,
                'base_calculo' => 1,
                'pis_pasep_aloquita' => 1,
                'pis_pasep_devido' => 1,
                'pis_pasep_recolher' => 1,
                'cofins_aloquita' => 1,
                'cofins_devido' => 1,
                'cofins_recolher' => 1,
                'created_at' => 1633545804,
                'updated_at' => 1633545804,
            ],
        ];
        parent::init();
    }
}
