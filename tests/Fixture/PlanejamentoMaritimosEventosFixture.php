<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PlanejamentoMaritimosEventosFixture
 */
class PlanejamentoMaritimosEventosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'planejamento_maritimos_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'situacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'evento_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'versao' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'data_hora_evento' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'planejamento_maritimos_id' => ['type' => 'index', 'columns' => ['planejamento_maritimos_id'], 'length' => []],
            'situacao_id' => ['type' => 'index', 'columns' => ['situacao_id'], 'length' => []],
            'evento_id' => ['type' => 'index', 'columns' => ['evento_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'planejamento_maritimos_eventos_ibfk_1' => ['type' => 'foreign', 'columns' => ['planejamento_maritimos_id'], 'references' => ['planejamento_maritimos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'planejamento_maritimos_eventos_ibfk_2' => ['type' => 'foreign', 'columns' => ['situacao_id'], 'references' => ['situacao_programacao_maritimas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'planejamento_maritimos_eventos_ibfk_3' => ['type' => 'foreign', 'columns' => ['evento_id'], 'references' => ['eventos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'planejamento_maritimos_id' => 1,
                'situacao_id' => 1,
                'evento_id' => 1,
                'versao' => 'Lorem ipsum dolor sit amet',
                'data_hora_evento' => '2020-01-27 17:46:55'
            ],
        ];
        parent::init();
    }
}
