<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProtocoloCapaFixture
 *
 */
class ProtocoloCapaFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'protocolo_capa';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'carga' => ['type' => 'string', 'length' => 9, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'localizador' => ['type' => 'string', 'length' => 15, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'data_agendamento' => ['type' => 'string', 'length' => 16, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'cliente' => ['type' => 'string', 'length' => 28, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'transportadora' => ['type' => 'string', 'length' => 26, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'placa_caminhao' => ['type' => 'string', 'length' => 7, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'paca_reboques' => ['type' => 'string', 'length' => 17, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'motorista' => ['type' => 'string', 'length' => 37, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'tipo_operacao' => ['type' => 'string', 'length' => 8, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'portal_agendamento_id' => ['type' => 'string', 'length' => 1, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_options' => [
            'engine' => null,
            'collation' => null
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'carga' => 'Lorem i',
            'localizador' => 'Lorem ipsum d',
            'data_agendamento' => 'Lorem ipsum do',
            'cliente' => 'Lorem ipsum dolor sit amet',
            'transportadora' => 'Lorem ipsum dolor sit am',
            'placa_caminhao' => 'Lorem',
            'paca_reboques' => 'Lorem ipsum dol',
            'motorista' => 'Lorem ipsum dolor sit amet',
            'tipo_operacao' => 'Lorem ',
            'portal_agendamento_id' => 'Lorem ipsum dolor sit ame'
        ],
    ];
}
