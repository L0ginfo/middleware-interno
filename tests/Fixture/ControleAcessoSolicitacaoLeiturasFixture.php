<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ControleAcessoSolicitacaoLeiturasFixture
 */
class ControleAcessoSolicitacaoLeiturasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'controle_acesso_controladora_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'credenciamento_pessoa_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'data_hora' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'ativo' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'controle_acesso_equipamento_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'controle_acesso_controladora_id' => ['type' => 'index', 'columns' => ['controle_acesso_controladora_id'], 'length' => []],
            'credenciamento_pessoa_id' => ['type' => 'index', 'columns' => ['credenciamento_pessoa_id'], 'length' => []],
            'controle_acesso_equipamento_id' => ['type' => 'index', 'columns' => ['controle_acesso_equipamento_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'controle_acesso_solicitacao_leituras_ibfk_1' => ['type' => 'foreign', 'columns' => ['controle_acesso_controladora_id'], 'references' => ['controle_acesso_controladoras', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'controle_acesso_solicitacao_leituras_ibfk_2' => ['type' => 'foreign', 'columns' => ['credenciamento_pessoa_id'], 'references' => ['credenciamento_pessoas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'controle_acesso_solicitacao_leituras_ibfk_3' => ['type' => 'foreign', 'columns' => ['controle_acesso_equipamento_id'], 'references' => ['controle_acesso_equipamentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'credenciamento_pessoa_id' => 1,
                'data_hora' => '2022-01-12 14:13:48',
                'ativo' => 1,
                'controle_acesso_equipamento_id' => 1,
            ],
        ];
        parent::init();
    }
}
