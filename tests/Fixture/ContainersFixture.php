<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ContainersFixture
 */
class ContainersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'numero' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'capacidade_m3' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'mes_ano_fabricacao' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'tara' => ['type' => 'decimal', 'length' => 18, 'precision' => 8, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'payload' => ['type' => 'decimal', 'length' => 18, 'precision' => 8, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'temp_minima' => ['type' => 'decimal', 'length' => 18, 'precision' => 8, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'temp_maxima' => ['type' => 'decimal', 'length' => 18, 'precision' => 8, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'armador_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tipo_iso_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'armador_id' => ['type' => 'index', 'columns' => ['armador_id'], 'length' => []],
            'tipo_iso_id' => ['type' => 'index', 'columns' => ['tipo_iso_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'containers_ibfk_1' => ['type' => 'foreign', 'columns' => ['armador_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'containers_ibfk_2' => ['type' => 'foreign', 'columns' => ['tipo_iso_id'], 'references' => ['tipo_isos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'numero' => 'Lorem ipsum dolor sit amet',
                'capacidade_m3' => 'Lorem ipsum dolor sit amet',
                'mes_ano_fabricacao' => 'Lorem ipsum dolor sit amet',
                'tara' => 1.5,
                'payload' => 1.5,
                'temp_minima' => 1.5,
                'temp_maxima' => 1.5,
                'armador_id' => 1,
                'tipo_iso_id' => 1,
            ],
        ];
        parent::init();
    }
}
