<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ItensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ItensTable Test Case
 */
class ItensTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.itens',
        'app.embalagens',
        'app.carga_gerais',
        'app.codigo_onus',
        'app.lotes',
        'app.tipo_conhecimentos',
        'app.moedas',
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
        'app.containers',
        'app.iso_codes',
        'app.lotes_entradas',
        'app.cliente',
        'app.despachante',
        'app.representante',
        'app.paises',
        'app.anexos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Itens') ? [] : ['className' => 'App\Model\Table\ItensTable'];
        $this->Itens = TableRegistry::get('Itens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Itens);

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

    /**
     * Test validaMaiorIdade method
     *
     * @return void
     */
    public function testValidaMaiorIdade()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test beforeSave method
     *
     * @return void
     */
    public function testBeforeSave()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
