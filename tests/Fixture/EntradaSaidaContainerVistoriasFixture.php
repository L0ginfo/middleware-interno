<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EntradaSaidaContainerVistoriasFixture
 */
class EntradaSaidaContainerVistoriasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'entrada_saida_container_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'vistoria_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'entrada_saida_container_id' => ['type' => 'index', 'columns' => ['entrada_saida_container_id'], 'length' => []],
            'vistoria_id' => ['type' => 'index', 'columns' => ['vistoria_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'entrada_saida_container_vistorias_ibfk_1' => ['type' => 'foreign', 'columns' => ['entrada_saida_container_id'], 'references' => ['entrada_saida_containers', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'entrada_saida_container_vistorias_ibfk_2' => ['type' => 'foreign', 'columns' => ['vistoria_id'], 'references' => ['vistorias', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'entrada_saida_container_id' => 1,
                'vistoria_id' => 1,
            ],
        ];
        parent::init();
    }
}
