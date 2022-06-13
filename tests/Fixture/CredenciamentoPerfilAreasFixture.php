<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CredenciamentoPerfilAreasFixture
 */
class CredenciamentoPerfilAreasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'credenciamento_perfil_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'controle_acesso_area_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'credenciamento_perfil_id' => ['type' => 'index', 'columns' => ['credenciamento_perfil_id'], 'length' => []],
            'controle_acesso_area_id' => ['type' => 'index', 'columns' => ['controle_acesso_area_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'credenciamento_perfil_areas_ibfk_1' => ['type' => 'foreign', 'columns' => ['credenciamento_perfil_id'], 'references' => ['credenciamento_perfis', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'credenciamento_perfil_areas_ibfk_2' => ['type' => 'foreign', 'columns' => ['controle_acesso_area_id'], 'references' => ['controle_acesso_areas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'credenciamento_perfil_id' => 1,
                'controle_acesso_area_id' => 1,
            ],
        ];
        parent::init();
    }
}
