<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EntradaSaidaFluxoContainersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EntradaSaidaFluxoContainersTable Test Case
 */
class EntradaSaidaFluxoContainersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EntradaSaidaFluxoContainersTable
     */
    public $EntradaSaidaFluxoContainers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EntradaSaidaFluxoContainers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EntradaSaidaFluxoContainers') ? [] : ['className' => EntradaSaidaFluxoContainersTable::class];
        $this->EntradaSaidaFluxoContainers = TableRegistry::getTableLocator()->get('EntradaSaidaFluxoContainers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EntradaSaidaFluxoContainers);

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
