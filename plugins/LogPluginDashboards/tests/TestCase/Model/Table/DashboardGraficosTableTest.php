<?php
namespace LogPluginDashboards\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use LogPluginDashboards\Model\Table\DashboardGraficosTable;

/**
 * LogPluginDashboards\Model\Table\DashboardGraficosTable Test Case
 */
class DashboardGraficosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \LogPluginDashboards\Model\Table\DashboardGraficosTable
     */
    public $DashboardGraficos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.LogPluginDashboards.DashboardGraficos',
        'plugin.LogPluginDashboards.Consultas',
        'plugin.LogPluginDashboards.Dashboards',
        'plugin.LogPluginDashboards.DashboardGraficoTipos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DashboardGraficos') ? [] : ['className' => DashboardGraficosTable::class];
        $this->DashboardGraficos = TableRegistry::getTableLocator()->get('DashboardGraficos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DashboardGraficos);

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
