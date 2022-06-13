<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProgramacaoLiberacaoDocumentaisFixture
 */
class ProgramacaoLiberacaoDocumentaisFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'liberacao_documental_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'liberacao_documental_transportadora_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'programacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'liberacao_documental_id' => ['type' => 'index', 'columns' => ['liberacao_documental_id'], 'length' => []],
            'liberacao_documental_transportadora_id' => ['type' => 'index', 'columns' => ['liberacao_documental_transportadora_id'], 'length' => []],
            'programacao_id' => ['type' => 'index', 'columns' => ['programacao_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'programacao_liberacao_documentais_ibfk_1' => ['type' => 'foreign', 'columns' => ['liberacao_documental_id'], 'references' => ['liberacoes_documentais', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'programacao_liberacao_documentais_ibfk_2' => ['type' => 'foreign', 'columns' => ['liberacao_documental_transportadora_id'], 'references' => ['liberacao_documental_transportadoras', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'programacao_liberacao_documentais_ibfk_3' => ['type' => 'foreign', 'columns' => ['programacao_id'], 'references' => ['programacoes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'liberacao_documental_id' => 1,
                'liberacao_documental_transportadora_id' => 1,
                'programacao_id' => 1,
            ],
        ];
        parent::init();
    }
}
