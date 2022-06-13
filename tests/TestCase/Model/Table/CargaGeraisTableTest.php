<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CargaGeraisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CargaGeraisTable Test Case
 */
class CargaGeraisTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.carga_gerais',
        'app.codigo_onus',
        'app.embalagens',
        'app.containers',
        'app.entradas',
        'app.empresas',
        'app.usuarios',
        'app.aros',
        'app.acos',
        'app.permissions',
        'app.empresas_usuarios',
        'app.perfis',
        'app.moedas',
        'app.paises',
        'app.documentos',
        'app.navio_viagens',
        'app.anexos',
        'app.iso_codes',
        'app.tamanhos',
        'app.modelos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CargaGerais') ? [] : ['className' => 'App\Model\Table\CargaGeraisTable'];
        $this->CargaGerais = TableRegistry::get('CargaGerais', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CargaGerais);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
