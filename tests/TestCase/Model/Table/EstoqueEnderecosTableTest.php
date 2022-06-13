<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EstoqueEnderecosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EstoqueEnderecosTable Test Case
 */
class EstoqueEnderecosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EstoqueEnderecosTable
     */
    public $EstoqueEnderecos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EstoqueEnderecos',
        'app.UnidadeMedidas',
        'app.Enderecos',
        'app.Estoques',
        'app.Empresas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EstoqueEnderecos') ? [] : ['className' => EstoqueEnderecosTable::class];
        $this->EstoqueEnderecos = TableRegistry::getTableLocator()->get('EstoqueEnderecos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EstoqueEnderecos);

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
