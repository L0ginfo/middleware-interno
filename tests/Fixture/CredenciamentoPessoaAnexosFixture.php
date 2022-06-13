<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CredenciamentoPessoaAnexosFixture
 */
class CredenciamentoPessoaAnexosFixture extends TestFixture
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
        'credenciamento_pessoa_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created_at' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'updated_at' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'anexo_id' => ['type' => 'index', 'columns' => ['anexo_id'], 'length' => []],
            'credenciamento_pessoa_id' => ['type' => 'index', 'columns' => ['credenciamento_pessoa_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'credenciamento_pessoa_anexos_ibfk_1' => ['type' => 'foreign', 'columns' => ['anexo_id'], 'references' => ['anexos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'credenciamento_pessoa_anexos_ibfk_2' => ['type' => 'foreign', 'columns' => ['credenciamento_pessoa_id'], 'references' => ['credenciamento_pessoas', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'credenciamento_pessoa_id' => 1,
                'created_at' => 1645792643,
                'updated_at' => 1645792643,
            ],
        ];
        parent::init();
    }
}
