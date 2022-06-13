<?php
namespace LogPluginDashboards\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use LogPluginDashboards\Model\Table\DashboardsTable;

/**
 * LogPluginDashboards\Model\Table\DashboardsTable Test Case
 */
class DashboardsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \LogPluginDashboards\Model\Table\DashboardsTable
     */
    public $Dashboards;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.LogPluginDashboards.Dashboards',
        'plugin.LogPluginDashboards.Perfis',
        'plugin.LogPluginDashboards.Usuarios',
        'plugin.LogPluginDashboards.DashboardCards',
        'plugin.LogPluginDashboards.DashboardGraficos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Dashboards') ? [] : ['className' => DashboardsTable::class];
        $this->Dashboards = TableRegistry::getTableLocator()->get('Dashboards', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Dashboards);

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
