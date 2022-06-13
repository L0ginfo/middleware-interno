<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TabelasPrecosEquipesTrabalhosFixture
 */
class TabelasPrecosEquipesTrabalhosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'tabelas_preco_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'equipes_trabalho_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'tabelas_preco_id' => ['type' => 'index', 'columns' => ['tabelas_preco_id'], 'length' => []],
            'equipes_trabalho_id' => ['type' => 'index', 'columns' => ['equipes_trabalho_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'tabelas_precos_equipes_trabalhos_ibfk_1' => ['type' => 'foreign', 'columns' => ['tabelas_preco_id'], 'references' => ['tabelas_precos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'tabelas_precos_equipes_trabalhos_ibfk_2' => ['type' => 'foreign', 'columns' => ['equipes_trabalho_id'], 'references' => ['equipes_trabalhos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'tabelas_preco_id' => 1,
                'equipes_trabalho_id' => 1
            ],
        ];
        parent::init();
    }
}
