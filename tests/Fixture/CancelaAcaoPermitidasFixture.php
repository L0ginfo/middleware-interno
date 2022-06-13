<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CancelaAcaoPermitidasFixture
 */
class CancelaAcaoPermitidasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'cancela_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'cancela_acao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'cancela_id' => ['type' => 'index', 'columns' => ['cancela_id'], 'length' => []],
            'cancela_acao_id' => ['type' => 'index', 'columns' => ['cancela_acao_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'cancela_acao_permitidas_ibfk_1' => ['type' => 'foreign', 'columns' => ['cancela_id'], 'references' => ['cancelas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'cancela_acao_permitidas_ibfk_2' => ['type' => 'foreign', 'columns' => ['cancela_acao_id'], 'references' => ['cancela_acoes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'cancela_id' => 1,
                'cancela_acao_id' => 1,
            ],
        ];
        parent::init();
    }
}
