<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PlanejamentoMaritimoInformacoesCabotagemFixture
 */
class PlanejamentoMaritimoInformacoesCabotagemFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'planejamento_maritimo_informacoes_cabotagem';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'planejamento_maritimo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ce_mercante' => ['type' => 'string', 'length' => 15, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'ncm' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'peso' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'quantidade' => ['type' => 'decimal', 'length' => 18, 'precision' => 6, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'planejamento_maritimo_id' => ['type' => 'index', 'columns' => ['planejamento_maritimo_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'planejamento_maritimo_informacoes_cabotagem_ibfk_1' => ['type' => 'foreign', 'columns' => ['planejamento_maritimo_id'], 'references' => ['planejamento_maritimos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'planejamento_maritimo_id' => 1,
                'ce_mercante' => 'Lorem ipsum dol',
                'ncm' => 'Lorem ipsum dolor sit amet',
                'peso' => 1.5,
                'quantidade' => 1.5,
            ],
        ];
        parent::init();
    }
}
