<?php
namespace LogPluginDashboards\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use LogPluginDashboards\Model\Table\DashboardCardsTable;

/**
 * LogPluginDashboards\Model\Table\DashboardCardsTable Test Case
 */
class DashboardCardsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \LogPluginDashboards\Model\Table\DashboardCardsTable
     */
    public $DashboardCards;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.LogPluginDashboards.DashboardCards',
        'plugin.LogPluginDashboards.Dashboards',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DashboardCards') ? [] : ['className' => DashboardCardsTable::class];
        $this->DashboardCards = TableRegistry::getTableLocator()->get('DashboardCards', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DashboardCards);

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
