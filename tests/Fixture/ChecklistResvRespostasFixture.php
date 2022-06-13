<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ChecklistResvRespostasFixture
 */
class ChecklistResvRespostasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'resposta' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'checklist_resv_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'checklist_pergunta_resposta_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'checklist_resv_pergunta_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'checklist_resv_id' => ['type' => 'index', 'columns' => ['checklist_resv_id'], 'length' => []],
            'checklist_pergunta_resposta_id' => ['type' => 'index', 'columns' => ['checklist_pergunta_resposta_id'], 'length' => []],
            'checklist_resv_pergunta_id' => ['type' => 'index', 'columns' => ['checklist_resv_pergunta_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'checklist_resv_respostas_ibfk_1' => ['type' => 'foreign', 'columns' => ['checklist_resv_id'], 'references' => ['checklist_resvs', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'checklist_resv_respostas_ibfk_2' => ['type' => 'foreign', 'columns' => ['checklist_pergunta_resposta_id'], 'references' => ['checklist_pergunta_respostas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'checklist_resv_respostas_ibfk_3' => ['type' => 'foreign', 'columns' => ['checklist_resv_pergunta_id'], 'references' => ['checklist_resv_perguntas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'resposta' => 'Lorem ipsum dolor sit amet',
                'checklist_resv_id' => 1,
                'checklist_pergunta_resposta_id' => 1,
                'checklist_resv_pergunta_id' => 1,
            ],
        ];
        parent::init();
    }
}
