<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LogradourosFixture
 */
class LogradourosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'num_cep' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'bairro_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'descricao' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'tipo_logradouro_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'tipo_logradouro_id' => ['type' => 'index', 'columns' => ['tipo_logradouro_id'], 'length' => []],
            'bairro_id' => ['type' => 'index', 'columns' => ['bairro_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'logradouros_ibfk_1' => ['type' => 'foreign', 'columns' => ['tipo_logradouro_id'], 'references' => ['tipo_logradouros', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'logradouros_ibfk_2' => ['type' => 'foreign', 'columns' => ['bairro_id'], 'references' => ['bairros', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'num_cep' => 'Lorem ipsum dolor sit amet',
                'bairro_id' => 1,
                'descricao' => 'Lorem ipsum dolor sit amet',
                'tipo_logradouro_id' => 1
            ],
        ];
        parent::init();
    }
}
