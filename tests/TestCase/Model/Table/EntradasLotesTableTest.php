<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EntradasLotesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EntradasLotesTable Test Case
 */
class EntradasLotesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.entradas_lotes',
        'app.entradas',
        'app.agendamentos',
        'app.usuarios',
        'app.aros',
        'app.acos',
        'app.permissions',
        'app.perfis',
        'app.empresas_usuarios',
        'app.empresas',
        'app.operacoes',
        'app.horarios',
        'app.operacao_documentos',
        'app.item_agendamentos',
        'app.itens',
        'app.embalagens',
        'app.carga_gerais',
        'app.codigo_onus',
        'app.lotes',
        'app.navio_viagens',
        'app.procedencias',
        'app.cliente',
        'app.despachante',
        'app.representante',
        'app.tipo_conhecimentos',
        'app.tipo_naturezas',
        'app.moedas',
        'app.paises',
        'app.anexos',
        'app.containers',
        'app.iso_codes',
        'app.entradas_containers',
        'app.documentos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('EntradasLotes') ? [] : ['className' => 'App\Model\Table\EntradasLotesTable'];
        $this->EntradasLotes = TableRegistry::get('EntradasLotes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EntradasLotes);

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
