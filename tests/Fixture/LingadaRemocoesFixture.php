<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LingadaRemocoesFixture
 */
class LingadaRemocoesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'remocao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ordem_servico_item_lingada_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created_at' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'updated_at' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'remocao_id' => ['type' => 'index', 'columns' => ['remocao_id'], 'length' => []],
            'ordem_servico_item_lingada_id' => ['type' => 'index', 'columns' => ['ordem_servico_item_lingada_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'lingada_remocoes_ibfk_1' => ['type' => 'foreign', 'columns' => ['remocao_id'], 'references' => ['remocoes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'lingada_remocoes_ibfk_2' => ['type' => 'foreign', 'columns' => ['ordem_servico_item_lingada_id'], 'references' => ['ordem_servico_item_lingadas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'remocao_id' => 1,
                'ordem_servico_item_lingada_id' => 1,
                'created_at' => 1603305113,
                'updated_at' => 1603305113,
            ],
        ];
        parent::init();
    }
}
