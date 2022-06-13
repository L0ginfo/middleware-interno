<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CredenciamentoPerfisFixture
 */
class CredenciamentoPerfisFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'perfil_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'validade_dias' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'situacao' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'motivo_situacao' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'tipo_acesso_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'perfil_id' => ['type' => 'index', 'columns' => ['perfil_id'], 'length' => []],
            'tipo_acesso_id' => ['type' => 'index', 'columns' => ['tipo_acesso_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'credenciamento_perfis_ibfk_1' => ['type' => 'foreign', 'columns' => ['perfil_id'], 'references' => ['perfis', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'credenciamento_perfis_ibfk_2' => ['type' => 'foreign', 'columns' => ['tipo_acesso_id'], 'references' => ['tipo_acessos', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'perfil_id' => 1,
                'validade_dias' => 1,
                'situacao' => 1,
                'motivo_situacao' => 'Lorem ipsum dolor sit amet',
                'tipo_acesso_id' => 1,
            ],
        ];
        parent::init();
    }
}
