<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SaidaItensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SaidaItensTable Test Case
 */
class SaidaItensTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.saida_itens',
        'app.docs',
        'app.agendamentos',
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
        $config = TableRegistry::exists('SaidaItens') ? [] : ['className' => 'App\Model\Table\SaidaItensTable'];
        $this->SaidaItens = TableRegistry::get('SaidaItens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SaidaItens);

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
