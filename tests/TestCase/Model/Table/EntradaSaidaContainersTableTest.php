<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EntradaSaidaContainersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EntradaSaidaContainersTable Test Case
 */
class EntradaSaidaContainersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EntradaSaidaContainersTable
     */
    public $EntradaSaidaContainers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EntradaSaidaContainers',
        'app.Resvs',
        'app.Containers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EntradaSaidaContainers') ? [] : ['className' => EntradaSaidaContainersTable::class];
        $this->EntradaSaidaContainers = TableRegistry::getTableLocator()->get('EntradaSaidaContainers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EntradaSaidaContainers);

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
