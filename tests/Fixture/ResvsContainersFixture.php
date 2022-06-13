<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ResvsContainersFixture
 */
class ResvsContainersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'container_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'documento_transporte_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'resv_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'operacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'cliente_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'liberacao_documental_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'booking_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'documento_genericos_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tipo' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'container_id' => ['type' => 'index', 'columns' => ['container_id'], 'length' => []],
            'documento_transporte_id' => ['type' => 'index', 'columns' => ['documento_transporte_id'], 'length' => []],
            'resv_id' => ['type' => 'index', 'columns' => ['resv_id'], 'length' => []],
            'operacao_id' => ['type' => 'index', 'columns' => ['operacao_id'], 'length' => []],
            'cliente_id' => ['type' => 'index', 'columns' => ['cliente_id'], 'length' => []],
            'liberacao_documental_id' => ['type' => 'index', 'columns' => ['liberacao_documental_id'], 'length' => []],
            'booking_id' => ['type' => 'index', 'columns' => ['booking_id'], 'length' => []],
            'documento_genericos_id' => ['type' => 'index', 'columns' => ['documento_genericos_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'resvs_containers_ibfk_1' => ['type' => 'foreign', 'columns' => ['container_id'], 'references' => ['containers', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'resvs_containers_ibfk_2' => ['type' => 'foreign', 'columns' => ['documento_transporte_id'], 'references' => ['documentos_transportes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'resvs_containers_ibfk_3' => ['type' => 'foreign', 'columns' => ['resv_id'], 'references' => ['resvs', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'resvs_containers_ibfk_4' => ['type' => 'foreign', 'columns' => ['operacao_id'], 'references' => ['operacoes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'resvs_containers_ibfk_5' => ['type' => 'foreign', 'columns' => ['cliente_id'], 'references' => ['empresas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'resvs_containers_ibfk_6' => ['type' => 'foreign', 'columns' => ['liberacao_documental_id'], 'references' => ['liberacoes_documentais', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'resvs_containers_ibfk_7' => ['type' => 'foreign', 'columns' => ['booking_id'], 'references' => ['bookings', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'resvs_containers_ibfk_8' => ['type' => 'foreign', 'columns' => ['documento_genericos_id'], 'references' => ['documento_genericos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'container_id' => 1,
                'documento_transporte_id' => 1,
                'resv_id' => 1,
                'operacao_id' => 1,
                'cliente_id' => 1,
                'liberacao_documental_id' => 1,
                'booking_id' => 1,
                'documento_genericos_id' => 1,
                'tipo' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
