<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HorarioBloqueadosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HorarioBloqueadosTable Test Case
 */
class HorarioBloqueadosTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.horario_bloqueados',
        'app.operacoes',
        'app.agendamentos',
        'app.usuarios',
        'app.aros',
        'app.acos',
        'app.permissions',
        'app.perfis',
        'app.empresas_usuarios',
        'app.empresas',
        'app.entradas',
        'app.documentos',
        'app.empresa_parceira_comercial',
        'app.lotes',
        'app.procedencias',
        'app.cliente',
        'app.despachante',
        'app.representante',
        'app.tipo_conhecimentos',
        'app.tipo_naturezas',
        'app.moedas',
        'app.paises',
        'app.recintos',
        'app.anexos',
        'app.carga_gerais',
        'app.codigo_onus',
        'app.embalagens',
        'app.containers',
        'app.iso_codes',
        'app.item_agendamentos',
        'app.itens',
        'app.consolidados',
        'app.entradas_containers',
        'app.pendencias',
        'app.pendencia_tipos',
        'app.entradas_lotes',
        'app.horarios',
        'app.operacao_documentos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('HorarioBloqueados') ? [] : ['className' => 'App\Model\Table\HorarioBloqueadosTable'];
        $this->HorarioBloqueados = TableRegistry::get('HorarioBloqueados', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->HorarioBloqueados);

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
