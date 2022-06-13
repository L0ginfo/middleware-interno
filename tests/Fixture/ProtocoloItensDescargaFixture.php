<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProtocoloItensDescargaFixture
 *
 */
class ProtocoloItensDescargaFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'protocolo_itens_descarga';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'container' => ['type' => 'string', 'length' => 9, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'numero_lote' => ['type' => 'string', 'length' => 14, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'tipo_documento' => ['type' => 'string', 'length' => 2, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'descricao' => ['type' => 'string', 'length' => 51, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
        'quantidade' => ['type' => 'string', 'length' => 4, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null, 'fixed' => null],
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
            'container' => 'Lorem i',
            'numero_lote' => 'Lorem ipsum ',
            'tipo_documento' => '',
            'descricao' => 'Lorem ipsum dolor sit amet',
            'quantidade' => 'Lo',
            'tipo_operacao' => 'Lorem ',
            'portal_agendamento_id' => 'Lorem ipsum dolor sit ame'
        ],
    ];
}
