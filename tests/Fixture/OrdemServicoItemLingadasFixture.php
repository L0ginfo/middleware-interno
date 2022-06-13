<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrdemServicoItemLingadasFixture
 */
class OrdemServicoItemLingadasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'codigo' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'qtde' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'peso' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'ordem_servico_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'sentido_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'terno_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'resv_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'plano_carga_porao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'ordem_servico_id' => ['type' => 'index', 'columns' => ['ordem_servico_id'], 'length' => []],
            'sentido_id' => ['type' => 'index', 'columns' => ['sentido_id'], 'length' => []],
            'terno_id' => ['type' => 'index', 'columns' => ['terno_id'], 'length' => []],
            'resv_id' => ['type' => 'index', 'columns' => ['resv_id'], 'length' => []],
            'plano_carga_porao_id' => ['type' => 'index', 'columns' => ['plano_carga_porao_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'ordem_servico_item_lingadas_ibfk_1' => ['type' => 'foreign', 'columns' => ['ordem_servico_id'], 'references' => ['ordem_servicos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'ordem_servico_item_lingadas_ibfk_2' => ['type' => 'foreign', 'columns' => ['sentido_id'], 'references' => ['sentidos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'ordem_servico_item_lingadas_ibfk_3' => ['type' => 'foreign', 'columns' => ['terno_id'], 'references' => ['ternos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'ordem_servico_item_lingadas_ibfk_4' => ['type' => 'foreign', 'columns' => ['resv_id'], 'references' => ['resvs', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'ordem_servico_item_lingadas_ibfk_5' => ['type' => 'foreign', 'columns' => ['plano_carga_porao_id'], 'references' => ['plano_carga_poroes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'codigo' => 'Lorem ipsum dolor sit amet',
                'qtde' => 1.5,
                'peso' => 1.5,
                'ordem_servico_id' => 1,
                'sentido_id' => 1,
                'terno_id' => 1,
                'resv_id' => 1,
                'plano_carga_porao_id' => 1,
            ],
        ];
        parent::init();
    }
}
