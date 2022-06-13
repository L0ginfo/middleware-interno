<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AssociacaoTernosFixture
 */
class AssociacaoTernosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'ordem_servico_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'porao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'terno_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'sentido_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created_at' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'updated_at' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'plano_carga_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'ordem_servico_id' => ['type' => 'index', 'columns' => ['ordem_servico_id'], 'length' => []],
            'porao_id' => ['type' => 'index', 'columns' => ['porao_id'], 'length' => []],
            'terno_id' => ['type' => 'index', 'columns' => ['terno_id'], 'length' => []],
            'sentido_id' => ['type' => 'index', 'columns' => ['sentido_id'], 'length' => []],
            'plano_carga_id' => ['type' => 'index', 'columns' => ['plano_carga_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'associacao_ternos_ibfk_1' => ['type' => 'foreign', 'columns' => ['ordem_servico_id'], 'references' => ['ordem_servicos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'associacao_ternos_ibfk_2' => ['type' => 'foreign', 'columns' => ['porao_id'], 'references' => ['poroes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'associacao_ternos_ibfk_3' => ['type' => 'foreign', 'columns' => ['terno_id'], 'references' => ['ternos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'associacao_ternos_ibfk_4' => ['type' => 'foreign', 'columns' => ['sentido_id'], 'references' => ['sentidos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'associacao_ternos_ibfk_5' => ['type' => 'foreign', 'columns' => ['plano_carga_id'], 'references' => ['plano_cargas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'ordem_servico_id' => 1,
                'porao_id' => 1,
                'terno_id' => 1,
                'sentido_id' => 1,
                'created_at' => 1603127262,
                'updated_at' => 1603127262,
                'plano_carga_id' => 1,
            ],
        ];
        parent::init();
    }
}
