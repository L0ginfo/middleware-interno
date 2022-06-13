<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LingadaAvariasFixture
 */
class LingadaAvariasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'descricao' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'avaria_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ordem_servico_item_lingada_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created_at' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'updated_at' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'avaria_id' => ['type' => 'index', 'columns' => ['avaria_id'], 'length' => []],
            'ordem_servico_item_lingada_id' => ['type' => 'index', 'columns' => ['ordem_servico_item_lingada_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'lingada_avarias_ibfk_1' => ['type' => 'foreign', 'columns' => ['avaria_id'], 'references' => ['avarias', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'lingada_avarias_ibfk_2' => ['type' => 'foreign', 'columns' => ['ordem_servico_item_lingada_id'], 'references' => ['ordem_servico_item_lingadas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'descricao' => 'Lorem ipsum dolor sit amet',
                'avaria_id' => 1,
                'ordem_servico_item_lingada_id' => 1,
                'created_at' => 1606087552,
                'updated_at' => 1606087552,
            ],
        ];
        parent::init();
    }
}
