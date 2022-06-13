<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FormacaoCargaVolumeItensFixture
 */
class FormacaoCargaVolumeItensFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'ordem_servico_item_separacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'formacao_carga_volume_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created_at' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'updated_at' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'quantidade' => ['type' => 'decimal', 'length' => 18, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'ordem_servico_item_separacao_id' => ['type' => 'index', 'columns' => ['ordem_servico_item_separacao_id'], 'length' => []],
            'formacao_carga_volume_id' => ['type' => 'index', 'columns' => ['formacao_carga_volume_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'formacao_carga_volume_itens_ibfk_1' => ['type' => 'foreign', 'columns' => ['ordem_servico_item_separacao_id'], 'references' => ['ordem_servico_item_separacoes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'formacao_carga_volume_itens_ibfk_2' => ['type' => 'foreign', 'columns' => ['formacao_carga_volume_id'], 'references' => ['formacao_carga_volumes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'ordem_servico_item_separacao_id' => 1,
                'formacao_carga_volume_id' => 1,
                'created_at' => 1588010685,
                'updated_at' => 1588010685,
                'quantidade' => 1.5,
            ],
        ];
        parent::init();
    }
}
