<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ControleAcessoControladorasFixture
 */
class ControleAcessoControladorasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'descricao' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'codigo' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'situacao' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ip' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'porta' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'offline_interval' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'anti_dupla' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'area_de_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'area_para_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'direcao_controladora_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'modelo_equipamento_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tipo_equipamento_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'area_de_id' => ['type' => 'index', 'columns' => ['area_de_id'], 'length' => []],
            'area_para_id' => ['type' => 'index', 'columns' => ['area_para_id'], 'length' => []],
            'direcao_controladora_id' => ['type' => 'index', 'columns' => ['direcao_controladora_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'controle_acesso_controladoras_ibfk_1' => ['type' => 'foreign', 'columns' => ['area_de_id'], 'references' => ['controle_acesso_areas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'controle_acesso_controladoras_ibfk_2' => ['type' => 'foreign', 'columns' => ['area_para_id'], 'references' => ['controle_acesso_areas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'controle_acesso_controladoras_ibfk_3' => ['type' => 'foreign', 'columns' => ['direcao_controladora_id'], 'references' => ['direcao_controladoras', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'descricao' => 'Lorem ipsum dolor sit amet',
                'codigo' => 'Lorem ipsum dolor sit amet',
                'situacao' => 1,
                'ip' => 'Lorem ipsum dolor sit amet',
                'porta' => 'Lorem ipsum dolor sit amet',
                'offline_interval' => 'Lorem ipsum dolor sit amet',
                'anti_dupla' => 1,
                'area_de_id' => 1,
                'area_para_id' => 1,
                'direcao_controladora_id' => 1,
                'modelo_equipamento_id' => 1,
                'tipo_equipamento_id' => 1,
            ],
        ];
        parent::init();
    }
}
