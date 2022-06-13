<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ViagensFixture
 */
class ViagensFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'codigo' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'descricao' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'transportadora_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'terminal_origem_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'terminal_destino_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'previsao_chegada' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'vagoes_cheios' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'vagoes_vazios' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'modal_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'operador_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'transportadora_id' => ['type' => 'index', 'columns' => ['transportadora_id'], 'length' => []],
            'modal_id' => ['type' => 'index', 'columns' => ['modal_id'], 'length' => []],
            'operador_id' => ['type' => 'index', 'columns' => ['operador_id'], 'length' => []],
            'terminal_origem_id' => ['type' => 'index', 'columns' => ['terminal_origem_id'], 'length' => []],
            'terminal_destino_id' => ['type' => 'index', 'columns' => ['terminal_destino_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'viagens_ibfk_1' => ['type' => 'foreign', 'columns' => ['transportadora_id'], 'references' => ['transportadoras', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'viagens_ibfk_2' => ['type' => 'foreign', 'columns' => ['modal_id'], 'references' => ['modais', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'viagens_ibfk_3' => ['type' => 'foreign', 'columns' => ['operador_id'], 'references' => ['usuarios', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'viagens_ibfk_4' => ['type' => 'foreign', 'columns' => ['terminal_origem_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'viagens_ibfk_5' => ['type' => 'foreign', 'columns' => ['terminal_destino_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'codigo' => 'Lorem ipsum dolor sit amet',
                'descricao' => 'Lorem ipsum dolor sit amet',
                'transportadora_id' => 1,
                'terminal_origem_id' => 1,
                'terminal_destino_id' => 1,
                'previsao_chegada' => '2021-01-26 13:32:36',
                'vagoes_cheios' => 1,
                'vagoes_vazios' => 1,
                'modal_id' => 1,
                'operador_id' => 1,
            ],
        ];
        parent::init();
    }
}
