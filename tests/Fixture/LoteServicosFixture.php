<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LoteServicosFixture
 *
 */
class LoteServicosFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'lote' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'tipo_servico_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created_by' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'iso' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'tipo_iso' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'container' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'tipo_container' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'cesv' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'placa' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'data_entrada' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'tipo_servico_status_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'os_sara' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'motorista_cpf' => ['type' => 'string', 'length' => 15, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'motorista_nome' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'transportadora_nome' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'transportadora_cnpj' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'data_avaliacao' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'lote_solicitacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'tipo_servico' => ['type' => 'index', 'columns' => ['tipo_servico_id'], 'length' => []],
            'tipo_servico_status_id' => ['type' => 'index', 'columns' => ['tipo_servico_status_id'], 'length' => []],
            'lote_solicitacao_id' => ['type' => 'index', 'columns' => ['lote_solicitacao_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'id' => ['type' => 'unique', 'columns' => ['id'], 'length' => []],
            'lote_servicos_ibfk_1' => ['type' => 'foreign', 'columns' => ['tipo_servico_id'], 'references' => ['tipo_servicos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'lote_servicos_status_ibfk_1' => ['type' => 'foreign', 'columns' => ['tipo_servico_status_id'], 'references' => ['tipo_servico_status', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'lote_solicita_fk' => ['type' => 'foreign', 'columns' => ['lote_solicitacao_id'], 'references' => ['lote_solicitacoes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
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
            'id' => 1,
            'lote' => 'Lorem ipsum dolor sit amet',
            'created' => '2016-11-17',
            'tipo_servico_id' => 1,
            'created_by' => 1,
            'iso' => 'Lorem ipsum dolor sit amet',
            'tipo_iso' => 1,
            'container' => 'Lorem ipsum dolor ',
            'tipo_container' => 'Lorem ipsum dolor sit amet',
            'cesv' => 'Lorem ipsum dolor sit amet',
            'placa' => 'Lorem ipsum dolor ',
            'data_entrada' => '2016-11-17 23:24:49',
            'tipo_servico_status_id' => 1,
            'os_sara' => 'Lorem ipsum dolor sit amet',
            'motorista_cpf' => 'Lorem ipsum d',
            'motorista_nome' => 'Lorem ipsum dolor sit amet',
            'transportadora_nome' => 'Lorem ipsum dolor sit amet',
            'transportadora_cnpj' => 'Lorem ipsum dolor ',
            'data_avaliacao' => '2016-11-17 23:24:49',
            'lote_solicitacao_id' => 1
        ],
    ];
}
