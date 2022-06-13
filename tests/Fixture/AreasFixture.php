<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AreasFixture
 */
class AreasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'descricao' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'comprimento' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'altura' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'largura' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'm2' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'm3' => ['type' => 'decimal', 'length' => 10, 'precision' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'ativo' => ['type' => 'integer', 'length' => 1, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'empresa_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'local_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'funcionalidade_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tipo_estrutura_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'c4_empresa_id_empresas' => ['type' => 'index', 'columns' => ['empresa_id'], 'length' => []],
            'c5_local_id_locais' => ['type' => 'index', 'columns' => ['local_id'], 'length' => []],
            'c6_funcionalidade_id_funcionalidades' => ['type' => 'index', 'columns' => ['funcionalidade_id'], 'length' => []],
            'c7_tipo_estrutura_id_tipo_estruturas' => ['type' => 'index', 'columns' => ['tipo_estrutura_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'c4_empresa_id_empresas' => ['type' => 'foreign', 'columns' => ['empresa_id'], 'references' => ['empresas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'c5_local_id_locais' => ['type' => 'foreign', 'columns' => ['local_id'], 'references' => ['locais', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'c6_funcionalidade_id_funcionalidades' => ['type' => 'foreign', 'columns' => ['funcionalidade_id'], 'references' => ['funcionalidades', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'c7_tipo_estrutura_id_tipo_estruturas' => ['type' => 'foreign', 'columns' => ['tipo_estrutura_id'], 'references' => ['tipo_estruturas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'comprimento' => 1.5,
                'altura' => 1.5,
                'largura' => 1.5,
                'm2' => 1.5,
                'm3' => 1.5,
                'ativo' => 1,
                'empresa_id' => 1,
                'local_id' => 1,
                'funcionalidade_id' => 1,
                'tipo_estrutura_id' => 1
            ],
        ];
        parent::init();
    }
}
