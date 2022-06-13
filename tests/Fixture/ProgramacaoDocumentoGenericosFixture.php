<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProgramacaoDocumentoGenericosFixture
 */
class ProgramacaoDocumentoGenericosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'programacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'documento_generico_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'programacao_id' => ['type' => 'index', 'columns' => ['programacao_id'], 'length' => []],
            'documento_generico_id' => ['type' => 'index', 'columns' => ['documento_generico_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'programacao_documento_genericos_ibfk_1' => ['type' => 'foreign', 'columns' => ['programacao_id'], 'references' => ['programacoes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'programacao_documento_genericos_ibfk_2' => ['type' => 'foreign', 'columns' => ['documento_generico_id'], 'references' => ['documento_genericos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'programacao_id' => 1,
                'documento_generico_id' => 1,
            ],
        ];
        parent::init();
    }
}
