<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PlanoCargaItemDestinosFixture
 */
class PlanoCargaItemDestinosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'plano_carga_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'documento_mercadoria_item_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'destino' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'local_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'plano_carga_id' => ['type' => 'index', 'columns' => ['plano_carga_id'], 'length' => []],
            'documento_mercadoria_item_id' => ['type' => 'index', 'columns' => ['documento_mercadoria_item_id'], 'length' => []],
            'local_id' => ['type' => 'index', 'columns' => ['local_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'plano_carga_item_destinos_ibfk_1' => ['type' => 'foreign', 'columns' => ['plano_carga_id'], 'references' => ['plano_cargas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'plano_carga_item_destinos_ibfk_2' => ['type' => 'foreign', 'columns' => ['documento_mercadoria_item_id'], 'references' => ['documentos_mercadorias_itens', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'plano_carga_item_destinos_ibfk_3' => ['type' => 'foreign', 'columns' => ['local_id'], 'references' => ['locais', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'plano_carga_id' => 1,
                'documento_mercadoria_item_id' => 1,
                'destino' => 1,
                'local_id' => 1,
            ],
        ];
        parent::init();
    }
}
