<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentoRegimeEspecialDocumentoMercadoriasFixture
 */
class DocumentoRegimeEspecialDocumentoMercadoriasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'documento_mercadoria_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'documento_regime_especial_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'documento_mercadoria_id' => ['type' => 'index', 'columns' => ['documento_mercadoria_id'], 'length' => []],
            'documento_regime_especial_id' => ['type' => 'index', 'columns' => ['documento_regime_especial_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'documento_regime_especial_documento_mercadorias_ibfk_1' => ['type' => 'foreign', 'columns' => ['documento_mercadoria_id'], 'references' => ['documentos_mercadorias', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'documento_regime_especial_documento_mercadorias_ibfk_2' => ['type' => 'foreign', 'columns' => ['documento_regime_especial_id'], 'references' => ['documento_regime_especiais', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'documento_mercadoria_id' => 1,
                'documento_regime_especial_id' => 1,
            ],
        ];
        parent::init();
    }
}
