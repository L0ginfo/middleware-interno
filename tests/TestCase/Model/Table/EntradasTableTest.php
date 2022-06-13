<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EntradasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EntradasTable Test Case
 */
class EntradasTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.entradas',
        'app.tipo_naturezas',
        'app.empresas',
        'app.usuarios',
        'app.aros',
        'app.acos',
        'app.permissions',
        'app.perfis',
        'app.empresas_usuarios',
        'app.documentos',
        'app.navio_viagens',
        'app.procedencias',
        'app.agendamentos',
        'app.operacoes',
        'app.horarios',
        'app.operacao_documentos',
        'app.item_agendamentos',
        'app.itens',
        'app.embalagens',
        'app.carga_gerais',
        'app.codigo_onus',
        'app.lotes',
        'app.tipo_conhecimentos',
        'app.moedas',
        'app.paises',
        'app.anexos',
        'app.containers',
        'app.iso_codes',
        'app.lotes_entradas',
        'app.containers_vinculados',
        'app.cliente',
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
        $config = TableRegistry::exists('Entradas') ? [] : ['className' => 'App\Model\Table\EntradasTable'];
        $this->Entradas = TableRegistry::get('Entradas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Entradas);

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
