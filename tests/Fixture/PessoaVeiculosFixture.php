<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PessoaVeiculosFixture
 */
class PessoaVeiculosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'credenciamento_veiculo_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'credenciamento_pessoa_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'credenciamento_veiculo_id' => ['type' => 'index', 'columns' => ['credenciamento_veiculo_id'], 'length' => []],
            'credenciamento_pessoa_id' => ['type' => 'index', 'columns' => ['credenciamento_pessoa_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'pessoa_veiculos_ibfk_1' => ['type' => 'foreign', 'columns' => ['credenciamento_veiculo_id'], 'references' => ['credenciamento_veiculos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'pessoa_veiculos_ibfk_2' => ['type' => 'foreign', 'columns' => ['credenciamento_pessoa_id'], 'references' => ['credenciamento_pessoas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'credenciamento_veiculo_id' => 1,
                'credenciamento_pessoa_id' => 1,
            ],
        ];
        parent::init();
    }
}
