<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ItemAgendamentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ItemAgendamentosTable Test Case
 */
class ItemAgendamentosTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.item_agendamentos',
        'app.agendamentos',
        'app.usuarios',
        'app.aros',
        'app.acos',
        'app.permissions',
        'app.empresas',
        'app.entradas',
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
        'app.cliente',
        'app.empresas_usuarios',
        'app.perfis',
        'app.despachante',
        'app.representante',
        'app.operacoes',
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
        $config = TableRegistry::exists('ItemAgendamentos') ? [] : ['className' => 'App\Model\Table\ItemAgendamentosTable'];
        $this->ItemAgendamentos = TableRegistry::get('ItemAgendamentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ItemAgendamentos);

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
