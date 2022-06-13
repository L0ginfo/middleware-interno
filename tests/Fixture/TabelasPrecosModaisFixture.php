<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TabelasPrecosModaisFixture
 */
class TabelasPrecosModaisFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'modal_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tabela_preco_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'modal_id' => ['type' => 'index', 'columns' => ['modal_id'], 'length' => []],
            'tabela_preco_id' => ['type' => 'index', 'columns' => ['tabela_preco_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'tabelas_precos_modais_ibfk_1' => ['type' => 'foreign', 'columns' => ['modal_id'], 'references' => ['modais', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'tabelas_precos_modais_ibfk_2' => ['type' => 'foreign', 'columns' => ['tabela_preco_id'], 'references' => ['tabelas_precos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'modal_id' => 1,
                'tabela_preco_id' => 1,
            ],
        ];
        parent::init();
    }
}
