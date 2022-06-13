<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ControleAcessoControladoraLeitorasFixture
 */
class ControleAcessoControladoraLeitorasFixture extends TestFixture
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
        'controle_acesso_equipamento_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'controle_acesso_controladora_id' => ['type' => 'index', 'columns' => ['controle_acesso_controladora_id'], 'length' => []],
            'controle_acesso_equipamento_id' => ['type' => 'index', 'columns' => ['controle_acesso_equipamento_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'controle_acesso_controladora_leitoras_ibfk_1' => ['type' => 'foreign', 'columns' => ['controle_acesso_controladora_id'], 'references' => ['controle_acesso_controladoras', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'controle_acesso_controladora_leitoras_ibfk_2' => ['type' => 'foreign', 'columns' => ['controle_acesso_equipamento_id'], 'references' => ['controle_acesso_equipamentos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'controle_acesso_equipamento_id' => 1,
            ],
        ];
        parent::init();
    }
}
