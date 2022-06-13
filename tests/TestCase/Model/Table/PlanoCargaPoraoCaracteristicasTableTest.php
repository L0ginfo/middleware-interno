<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlanoCargaPoraoCaracteristicasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlanoCargaPoraoCaracteristicasTable Test Case
 */
class PlanoCargaPoraoCaracteristicasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlanoCargaPoraoCaracteristicasTable
     */
    public $PlanoCargaPoraoCaracteristicas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PlanoCargaPoraoCaracteristicas',
        'app.PlanoCargas',
        'app.PlanoCargaPoroes',
        'app.TipoCaracteristicas',
        'app.PlanoCargaCaracteristicas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PlanoCargaPoraoCaracteristicas') ? [] : ['className' => PlanoCargaPoraoCaracteristicasTable::class];
        $this->PlanoCargaPoraoCaracteristicas = TableRegistry::getTableLocator()->get('PlanoCargaPoraoCaracteristicas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PlanoCargaPoraoCaracteristicas);

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
