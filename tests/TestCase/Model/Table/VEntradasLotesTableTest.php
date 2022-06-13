<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VEntradasLotesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VEntradasLotesTable Test Case
 */
class VEntradasLotesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.v_entradas_lotes',
        'app.entradas',
        'app.agendamentos',
        'app.usuarios',
        'app.aros',
        'app.acos',
        'app.permissions',
        'app.perfis',
        'app.empresas_usuarios',
        'app.empresas',
        'app.lotes',
        'app.procedencias',
        'app.cliente',
        'app.liberado_clientefinais',
        'app.empresas_clientes',
        'app.empresas_clientes_finais',
        'app.despachante',
        'app.representante',
        'app.agente_master',
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
        'app.situacao_agendamentos',
        'app.operacoes',
        'app.horarios',
        'app.horario_liberados',
        'app.operacao_documentos',
        'app.documentos',
        'app.empresa_parceira_comercial'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('VEntradasLotes') ? [] : ['className' => 'App\Model\Table\VEntradasLotesTable'];
        $this->VEntradasLotes = TableRegistry::get('VEntradasLotes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->VEntradasLotes);

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
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
