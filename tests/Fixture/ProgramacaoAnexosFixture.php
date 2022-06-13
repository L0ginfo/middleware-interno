<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProgramacaoAnexosFixture
 */
class ProgramacaoAnexosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'null' => false, 'default' => null, 'precision' => null, 'comment' => null, 'unsigned' => null],
        'programacao_id' => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => null, 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        'anexo_id' => ['type' => 'integer', 'length' => 10, 'null' => false, 'default' => null, 'precision' => null, 'comment' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'programacao_anexos_programacao_id' => ['type' => 'foreign', 'columns' => ['programacao_id'], 'references' => ['programacoes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'programacao_anexos_anexo_id' => ['type' => 'foreign', 'columns' => ['anexo_id'], 'references' => ['anexos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'anexo_id' => 1,
            ],
        ];
        parent::init();
    }
}
