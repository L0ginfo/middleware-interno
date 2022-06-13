<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentoRegimeEspecialTributosFixture
 */
class DocumentoRegimeEspecialTributosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'documento_regime_especial_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tributo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'suspenso' => ['type' => 'float', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'recolhido' => ['type' => 'float', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'created_at' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'updated_at' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'documento_regime_especial_id' => ['type' => 'index', 'columns' => ['documento_regime_especial_id'], 'length' => []],
            'tributo_id' => ['type' => 'index', 'columns' => ['tributo_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'documento_regime_especial_tributos_ibfk_1' => ['type' => 'foreign', 'columns' => ['documento_regime_especial_id'], 'references' => ['documento_regime_especiais', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'documento_regime_especial_tributos_ibfk_2' => ['type' => 'foreign', 'columns' => ['tributo_id'], 'references' => ['tributos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'tributo_id' => 1,
                'suspenso' => 1,
                'recolhido' => 1,
                'created_at' => 1633470173,
                'updated_at' => 1633470173,
            ],
        ];
        parent::init();
    }
}
