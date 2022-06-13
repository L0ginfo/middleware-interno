<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentosTransportesFixture
 */
class DocumentosTransportesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'numero' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'data_emissao' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'valor_total' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'quantidade' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'peso_bruto' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'peso_liquido' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'valor_frete' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'valor_seguro' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'numero_voo' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'modal_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'cliente_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'despachante_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'agente_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'parceiro_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tipo_documento_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'empresa_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'modal_id' => ['type' => 'index', 'columns' => ['modal_id'], 'length' => []],
            'cliente_id' => ['type' => 'index', 'columns' => ['cliente_id'], 'length' => []],
            'despachante_id' => ['type' => 'index', 'columns' => ['despachante_id'], 'length' => []],
            'agente_id' => ['type' => 'index', 'columns' => ['agente_id'], 'length' => []],
            'parceiro_id' => ['type' => 'index', 'columns' => ['parceiro_id'], 'length' => []],
            'tipo_documento_id' => ['type' => 'index', 'columns' => ['tipo_documento_id'], 'length' => []],
            'empresa_id' => ['type' => 'index', 'columns' => ['empresa_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'documentos_transportes_ibfk_1' => ['type' => 'foreign', 'columns' => ['modal_id'], 'references' => ['modais', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'documentos_transportes_ibfk_2' => ['type' => 'foreign', 'columns' => ['cliente_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'documentos_transportes_ibfk_3' => ['type' => 'foreign', 'columns' => ['despachante_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'documentos_transportes_ibfk_4' => ['type' => 'foreign', 'columns' => ['agente_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'documentos_transportes_ibfk_5' => ['type' => 'foreign', 'columns' => ['parceiro_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'documentos_transportes_ibfk_6' => ['type' => 'foreign', 'columns' => ['tipo_documento_id'], 'references' => ['tipo_documentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'documentos_transportes_ibfk_7' => ['type' => 'foreign', 'columns' => ['empresa_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'numero' => 'Lorem ipsum dolor sit amet',
                'data_emissao' => '2020-02-17',
                'valor_total' => 1.5,
                'quantidade' => 1.5,
                'peso_bruto' => 1.5,
                'peso_liquido' => 1.5,
                'valor_frete' => 1.5,
                'valor_seguro' => 1.5,
                'numero_voo' => 'Lorem ipsum dolor ',
                'modal_id' => 1,
                'cliente_id' => 1,
                'despachante_id' => 1,
                'agente_id' => 1,
                'parceiro_id' => 1,
                'tipo_documento_id' => 1,
                'empresa_id' => 1,
            ],
        ];
        parent::init();
    }
}
