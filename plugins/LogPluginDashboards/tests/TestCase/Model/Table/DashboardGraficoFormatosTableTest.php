<?php
namespace LogPluginDashboards\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use LogPluginDashboards\Model\Table\DashboardGraficoFormatosTable;

/**
 * LogPluginDashboards\Model\Table\DashboardGraficoFormatosTable Test Case
 */
class DashboardGraficoFormatosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \LogPluginDashboards\Model\Table\DashboardGraficoFormatosTable
     */
    public $DashboardGraficoFormatos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.LogPluginDashboards.DashboardGraficoFormatos',
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
        $config = TableRegistry::getTableLocator()->exists('DashboardGraficoFormatos') ? [] : ['className' => DashboardGraficoFormatosTable::class];
        $this->DashboardGraficoFormatos = TableRegistry::getTableLocator()->get('DashboardGraficoFormatos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DashboardGraficoFormatos);

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
