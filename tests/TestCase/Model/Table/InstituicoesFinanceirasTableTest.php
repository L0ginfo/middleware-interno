<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InstituicoesFinanceirasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InstituicoesFinanceirasTable Test Case
 */
class InstituicoesFinanceirasTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.instituicoes_financeiras',
        'app.usuarios',
        'app.aros',
        'app.acos',
        'app.permissions',
        'app.empresas',
        'app.requerimentos',
        'app.documentos',
        'app.procedencias',
        'app.navio_viagens',
        'app.tipo_naturezas',
        'app.lotes',
        'app.tipo_conhecimentos',
        'app.moedas',
        'app.anexos',
        'app.carga_gerais',
        'app.codigo_onus',
        'app.embalagens',
        'app.containers',
        'app.iso_codes',
        'app.itens',
        'app.paises',
        'app.agendamentos',
        'app.cliente',
        'app.empresas_usuarios',
        'app.perfis',
        'app.despachante',
        'app.representante'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('InstituicoesFinanceiras') ? [] : ['className' => 'App\Model\Table\InstituicoesFinanceirasTable'];
        $this->InstituicoesFinanceiras = TableRegistry::get('InstituicoesFinanceiras', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InstituicoesFinanceiras);

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
