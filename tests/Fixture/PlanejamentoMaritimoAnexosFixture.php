<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PlanejamentoMaritimoAnexosFixture
 */
class PlanejamentoMaritimoAnexosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'planejamento_maritimo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'anexo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'caminho_arquivo' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'created_at' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'updated_at' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'planejamento_maritimo_id' => ['type' => 'index', 'columns' => ['planejamento_maritimo_id'], 'length' => []],
            'anexo_id' => ['type' => 'index', 'columns' => ['anexo_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'planejamento_maritimo_anexos_ibfk_1' => ['type' => 'foreign', 'columns' => ['planejamento_maritimo_id'], 'references' => ['planejamento_maritimos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'planejamento_maritimo_anexos_ibfk_2' => ['type' => 'foreign', 'columns' => ['anexo_id'], 'references' => ['anexos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'planejamento_maritimo_id' => 1,
                'anexo_id' => 1,
                'caminho_arquivo' => 'Lorem ipsum dolor sit amet',
                'created_at' => 1619555811,
                'updated_at' => 1619555811,
            ],
        ];
        parent::init();
    }
}
