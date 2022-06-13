<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * VistoriaAvariaRespostasFixture
 */
class VistoriaAvariaRespostasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'avaria_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'avaria_resposta_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'vistoria_avaria_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created_at' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'updated_at' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'avaria_id' => ['type' => 'index', 'columns' => ['avaria_id'], 'length' => []],
            'avaria_resposta_id' => ['type' => 'index', 'columns' => ['avaria_resposta_id'], 'length' => []],
            'vistoria_avaria_id' => ['type' => 'index', 'columns' => ['vistoria_avaria_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'vistoria_avaria_respostas_ibfk_1' => ['type' => 'foreign', 'columns' => ['avaria_id'], 'references' => ['avarias', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'vistoria_avaria_respostas_ibfk_2' => ['type' => 'foreign', 'columns' => ['avaria_resposta_id'], 'references' => ['avaria_respostas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'vistoria_avaria_respostas_ibfk_3' => ['type' => 'foreign', 'columns' => ['vistoria_avaria_id'], 'references' => ['vistoria_avarias', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'avaria_id' => 1,
                'avaria_resposta_id' => 1,
                'vistoria_avaria_id' => 1,
                'created_at' => 1612893220,
                'updated_at' => 1612893220,
            ],
        ];
        parent::init();
    }
}
