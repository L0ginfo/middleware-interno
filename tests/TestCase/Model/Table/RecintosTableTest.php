<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RecintosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RecintosTable Test Case
 */
class RecintosTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.recintos',
        'app.lotes',
        'app.empresas',
        'app.entradas',
        'app.agendamentos',
        'app.usuarios',
        'app.aros',
        'app.acos',
        'app.permissions',
        'app.perfis',
        'app.empresas_usuarios',
        'app.operacoes',
        'app.horarios',
        'app.operacao_documentos',
        'app.item_agendamentos',
        'app.itens',
        'app.embalagens',
        'app.carga_gerais',
        'app.codigo_onus',
        'app.containers',
        'app.iso_codes',
        'app.entradas_containers',
        'app.documentos',
        'app.entradas_lotes',
        'app.navio_viagens',
        'app.procedencias',
        'app.cliente',
        'app.despachante',
        'app.representante',
        'app.tipo_conhecimentos',
        'app.tipo_naturezas',
        'app.moedas',
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
        $config = TableRegistry::exists('Recintos') ? [] : ['className' => 'App\Model\Table\RecintosTable'];
        $this->Recintos = TableRegistry::get('Recintos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Recintos);

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
}
