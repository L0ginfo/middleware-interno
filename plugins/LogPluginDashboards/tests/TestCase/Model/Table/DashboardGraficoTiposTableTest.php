<?php
namespace LogPluginDashboards\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use LogPluginDashboards\Model\Table\DashboardGraficoTiposTable;

/**
 * LogPluginDashboards\Model\Table\DashboardGraficoTiposTable Test Case
 */
class DashboardGraficoTiposTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \LogPluginDashboards\Model\Table\DashboardGraficoTiposTable
     */
    public $DashboardGraficoTipos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.LogPluginDashboards.DashboardGraficoTipos',
        'plugin.LogPluginDashboards.DashboardGraficoFormatos',
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
        $config = TableRegistry::getTableLocator()->exists('DashboardGraficoTipos') ? [] : ['className' => DashboardGraficoTiposTable::class];
        $this->DashboardGraficoTipos = TableRegistry::getTableLocator()->get('DashboardGraficoTipos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DashboardGraficoTipos);

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
