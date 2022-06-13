<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentoTransporteAnexosFixture
 */
class DocumentoTransporteAnexosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'anexo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'documento_transporte_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created_at' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'updated_at' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'anexo_id' => ['type' => 'index', 'columns' => ['anexo_id'], 'length' => []],
            'documento_transporte_id' => ['type' => 'index', 'columns' => ['documento_transporte_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'documento_transporte_anexos_ibfk_1' => ['type' => 'foreign', 'columns' => ['anexo_id'], 'references' => ['anexos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'documento_transporte_anexos_ibfk_2' => ['type' => 'foreign', 'columns' => ['documento_transporte_id'], 'references' => ['documentos_transportes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'anexo_id' => 1,
                'documento_transporte_id' => 1,
                'created_at' => 1581537554,
                'updated_at' => 1581537554,
            ],
        ];
        parent::init();
    }
}
