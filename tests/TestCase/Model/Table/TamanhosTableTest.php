<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TamanhosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TamanhosTable Test Case
 */
class TamanhosTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tamanhos',
        'app.containers',
        'app.entradas',
        'app.empresas',
        'app.usuarios',
        'app.empresas_usuarios',
        'app.perfis',
        'app.moedas',
        'app.paises',
        'app.documentos',
        'app.navio_viagens',
        'app.anexos',
        'app.carga_gerais',
        'app.codigo_onus',
        'app.embalagens',
        'app.iso_codes',
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
        $config = TableRegistry::exists('Tamanhos') ? [] : ['className' => 'App\Model\Table\TamanhosTable'];
        $this->Tamanhos = TableRegistry::get('Tamanhos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tamanhos);

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
