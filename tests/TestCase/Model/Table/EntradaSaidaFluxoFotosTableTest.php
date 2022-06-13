<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EntradaSaidaFluxoFotosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EntradaSaidaFluxoFotosTable Test Case
 */
class EntradaSaidaFluxoFotosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EntradaSaidaFluxoFotosTable
     */
    public $EntradaSaidaFluxoFotos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EntradaSaidaFluxoFotos',
        'app.EntradaSaidaFluxos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EntradaSaidaFluxoFotos') ? [] : ['className' => EntradaSaidaFluxoFotosTable::class];
        $this->EntradaSaidaFluxoFotos = TableRegistry::getTableLocator()->get('EntradaSaidaFluxoFotos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EntradaSaidaFluxoFotos);

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
