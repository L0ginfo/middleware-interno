<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EmailAnexosFixture
 */
class EmailAnexosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'email_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'anexo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'email_id' => ['type' => 'index', 'columns' => ['email_id'], 'length' => []],
            'anexo_id' => ['type' => 'index', 'columns' => ['anexo_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'email_anexos_ibfk_1' => ['type' => 'foreign', 'columns' => ['email_id'], 'references' => ['emails', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'email_anexos_ibfk_2' => ['type' => 'foreign', 'columns' => ['anexo_id'], 'references' => ['anexos', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'email_id' => 1,
                'anexo_id' => 1,
            ],
        ];
        parent::init();
    }
}
