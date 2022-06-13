<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TipoIsosFixture
 */
class TipoIsosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'descricao' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'm3' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'm2' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'comprimento' => ['type' => 'decimal', 'length' => 18, 'precision' => 8, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'largura' => ['type' => 'decimal', 'length' => 18, 'precision' => 8, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'altura' => ['type' => 'decimal', 'length' => 18, 'precision' => 8, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'sigla' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'container_modelo_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'container_tamanho_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'container_modelo_id' => ['type' => 'index', 'columns' => ['container_modelo_id'], 'length' => []],
            'container_tamanho_id' => ['type' => 'index', 'columns' => ['container_tamanho_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'tipo_isos_ibfk_1' => ['type' => 'foreign', 'columns' => ['container_modelo_id'], 'references' => ['container_modelos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'tipo_isos_ibfk_2' => ['type' => 'foreign', 'columns' => ['container_tamanho_id'], 'references' => ['container_tamanhos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'descricao' => 'Lorem ipsum dolor sit amet',
                'm3' => 'Lorem ipsum dolor sit amet',
                'm2' => 'Lorem ipsum dolor sit amet',
                'comprimento' => 1.5,
                'largura' => 1.5,
                'altura' => 1.5,
                'sigla' => 'Lorem ipsum dolor sit amet',
                'container_modelo_id' => 1,
                'container_tamanho_id' => 1,
            ],
        ];
        parent::init();
    }
}
