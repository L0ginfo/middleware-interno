<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MapaTransacaoHistoricosFixture
 */
class MapaTransacaoHistoricosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'mapa_transacao_tipo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'mapa_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'mapa_transacao_tipo_id' => ['type' => 'index', 'columns' => ['mapa_transacao_tipo_id'], 'length' => []],
            'mapa_id' => ['type' => 'index', 'columns' => ['mapa_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'mapa_transacao_historicos_ibfk_1' => ['type' => 'foreign', 'columns' => ['mapa_transacao_tipo_id'], 'references' => ['mapa_transacao_tipos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'mapa_transacao_historicos_ibfk_2' => ['type' => 'foreign', 'columns' => ['mapa_id'], 'references' => ['mapas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'mapa_transacao_tipo_id' => 1,
                'mapa_id' => 1,
            ],
        ];
        parent::init();
    }
}
