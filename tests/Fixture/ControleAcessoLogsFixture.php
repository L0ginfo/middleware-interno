<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ControleAcessoLogsFixture
 */
class ControleAcessoLogsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'controle_acesso_controladora_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ip' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'area_de_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'area_para_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'direcao_controladora_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'liberado' => ['type' => 'string', 'length' => 1, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'cracha' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'mensagem' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'data_hora' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'tipo_acesso_id' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'credenciamento_pessoa_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'controle_acesso_evento_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'controle_acesso_equipamento_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'status' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'controle_acesso_evento_id' => ['type' => 'index', 'columns' => ['controle_acesso_evento_id'], 'length' => []],
            'controle_acesso_equipamento_id' => ['type' => 'index', 'columns' => ['controle_acesso_equipamento_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'controle_acesso_logs_ibfk_2' => ['type' => 'foreign', 'columns' => ['controle_acesso_equipamento_id'], 'references' => ['controle_acesso_equipamentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'controle_acesso_logs_ibfk_1' => ['type' => 'foreign', 'columns' => ['controle_acesso_evento_id'], 'references' => ['controle_acesso_eventos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'controle_acesso_controladora_id' => 1,
                'ip' => 'Lorem ipsum dolor sit amet',
                'area_de_id' => 1,
                'area_para_id' => 1,
                'direcao_controladora_id' => 1,
                'liberado' => 'L',
                'cracha' => 'Lorem ipsum dolor sit amet',
                'mensagem' => 'Lorem ipsum dolor sit amet',
                'data_hora' => '2022-01-26 16:10:51',
                'tipo_acesso_id' => 'Lorem ipsum dolor sit amet',
                'credenciamento_pessoa_id' => 1,
                'controle_acesso_evento_id' => 1,
                'controle_acesso_equipamento_id' => 1,
                'status' => 1,
            ],
        ];
        parent::init();
    }
}
