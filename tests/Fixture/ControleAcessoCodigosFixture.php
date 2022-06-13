<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ControleAcessoCodigosFixture
 */
class ControleAcessoCodigosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'tipo_acesso_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'codigo' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'credenciamento_pessoa_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'controle_acesso_solicitacao_leitura_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'credenciamento_pessoa_id' => ['type' => 'index', 'columns' => ['credenciamento_pessoa_id'], 'length' => []],
            'controle_acesso_solicitacao_leitura_id' => ['type' => 'index', 'columns' => ['controle_acesso_solicitacao_leitura_id'], 'length' => []],
            'tipo_acesso_id' => ['type' => 'index', 'columns' => ['tipo_acesso_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'controle_acesso_codigos_ibfk_1' => ['type' => 'foreign', 'columns' => ['credenciamento_pessoa_id'], 'references' => ['credenciamento_pessoas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'controle_acesso_codigos_ibfk_2' => ['type' => 'foreign', 'columns' => ['controle_acesso_solicitacao_leitura_id'], 'references' => ['controle_acesso_solicitacao_leituras', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'controle_acesso_codigos_ibfk_3' => ['type' => 'foreign', 'columns' => ['tipo_acesso_id'], 'references' => ['tipo_acessos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'tipo_acesso_id' => 1,
                'codigo' => 'Lorem ipsum dolor sit amet',
                'credenciamento_pessoa_id' => 1,
                'controle_acesso_solicitacao_leitura_id' => 1,
            ],
        ];
        parent::init();
    }
}
