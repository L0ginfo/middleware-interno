<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EntradaSaidaContainersFixture
 */
class EntradaSaidaContainersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'resv_entrada_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'resv_saida_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'container_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tipo' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'resv_entrada_id' => ['type' => 'index', 'columns' => ['resv_entrada_id'], 'length' => []],
            'resv_saida_id' => ['type' => 'index', 'columns' => ['resv_saida_id'], 'length' => []],
            'container_id' => ['type' => 'index', 'columns' => ['container_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'entrada_saida_containers_ibfk_1' => ['type' => 'foreign', 'columns' => ['resv_entrada_id'], 'references' => ['resvs', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'entrada_saida_containers_ibfk_2' => ['type' => 'foreign', 'columns' => ['resv_saida_id'], 'references' => ['resvs', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'entrada_saida_containers_ibfk_3' => ['type' => 'foreign', 'columns' => ['container_id'], 'references' => ['containers', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'resv_entrada_id' => 1,
                'resv_saida_id' => 1,
                'container_id' => 1,
                'tipo' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
