<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProgramacaoLiberacaoDocumentalItensFixture
 */
class ProgramacaoLiberacaoDocumentalItensFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'programacao_liberacao_documental_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'liberacao_documental_item_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'liberacao_documental_transportadora_item_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'programacao_liberacao_documental_id' => ['type' => 'index', 'columns' => ['programacao_liberacao_documental_id'], 'length' => []],
            'liberacao_documental_item_id' => ['type' => 'index', 'columns' => ['liberacao_documental_item_id'], 'length' => []],
            'liberacao_documental_transportadora_item_id' => ['type' => 'index', 'columns' => ['liberacao_documental_transportadora_item_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'programacao_liberacao_documental_itens_ibfk_1' => ['type' => 'foreign', 'columns' => ['programacao_liberacao_documental_id'], 'references' => ['programacao_liberacao_documentais', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'programacao_liberacao_documental_itens_ibfk_2' => ['type' => 'foreign', 'columns' => ['liberacao_documental_item_id'], 'references' => ['liberacoes_documentais_itens', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'programacao_liberacao_documental_itens_ibfk_3' => ['type' => 'foreign', 'columns' => ['liberacao_documental_transportadora_item_id'], 'references' => ['liberacao_documental_transportadora_itens', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'programacao_liberacao_documental_id' => 1,
                'liberacao_documental_item_id' => 1,
                'liberacao_documental_transportadora_item_id' => 1,
            ],
        ];
        parent::init();
    }
}
