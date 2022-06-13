<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrdemServicoCarregamentosFixture
 */
class OrdemServicoCarregamentosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'quantidade_carregada' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'm2_carregada' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'm3_carregada' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'empresa_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'estoque_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ordem_servico_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'empresa_id' => ['type' => 'index', 'columns' => ['empresa_id'], 'length' => []],
            'estoque_id' => ['type' => 'index', 'columns' => ['estoque_id'], 'length' => []],
            'ordem_servico_id' => ['type' => 'index', 'columns' => ['ordem_servico_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'ordem_servico_carregamentos_ibfk_1' => ['type' => 'foreign', 'columns' => ['empresa_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'ordem_servico_carregamentos_ibfk_2' => ['type' => 'foreign', 'columns' => ['estoque_id'], 'references' => ['estoques', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'ordem_servico_carregamentos_ibfk_3' => ['type' => 'foreign', 'columns' => ['ordem_servico_id'], 'references' => ['ordem_servicos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'quantidade_carregada' => 1.5,
                'm2_carregada' => 1.5,
                'm3_carregada' => 1.5,
                'empresa_id' => 1,
                'estoque_id' => 1,
                'ordem_servico_id' => 1
            ],
        ];
        parent::init();
    }
}
