<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AnexoTabelasFixture
 */
class AnexoTabelasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'anexo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'id_tabela' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tabela' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'anexo_tipo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'anexo_situacao_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'anexo_id' => ['type' => 'index', 'columns' => ['anexo_id'], 'length' => []],
            'anexo_tipo_id' => ['type' => 'index', 'columns' => ['anexo_tipo_id'], 'length' => []],
            'anexo_situacao_id' => ['type' => 'index', 'columns' => ['anexo_situacao_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'anexo_tabelas_ibfk_1' => ['type' => 'foreign', 'columns' => ['anexo_id'], 'references' => ['anexos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'anexo_tabelas_ibfk_2' => ['type' => 'foreign', 'columns' => ['anexo_tipo_id'], 'references' => ['anexo_tipos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'anexo_tabelas_ibfk_3' => ['type' => 'foreign', 'columns' => ['anexo_situacao_id'], 'references' => ['anexo_situacoes', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'anexo_id' => 1,
                'id_tabela' => 1,
                'tabela' => 'Lorem ipsum dolor sit amet',
                'anexo_tipo_id' => 1,
                'anexo_situacao_id' => 1,
            ],
        ];
        parent::init();
    }
}
