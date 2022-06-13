<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EntradaSaidaFluxosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EntradaSaidaFluxosTable Test Case
 */
class EntradaSaidaFluxosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EntradaSaidaFluxosTable
     */
    public $EntradaSaidaFluxos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EntradaSaidaFluxos',
        'app.Passagens',
        'app.CancelaEntradas',
        'app.CancelaSiadas',
        'app.Programacoes',
        'app.Balancas',
        'app.EntradaSaidaFluxoFotos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EntradaSaidaFluxos') ? [] : ['className' => EntradaSaidaFluxosTable::class];
        $this->EntradaSaidaFluxos = TableRegistry::getTableLocator()->get('EntradaSaidaFluxos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EntradaSaidaFluxos);

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
