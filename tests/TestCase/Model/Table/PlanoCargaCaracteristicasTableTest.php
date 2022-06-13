<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlanoCargaCaracteristicasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlanoCargaCaracteristicasTable Test Case
 */
class PlanoCargaCaracteristicasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlanoCargaCaracteristicasTable
     */
    public $PlanoCargaCaracteristicas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PlanoCargaCaracteristicas',
        'app.PlanoCargas',
        'app.Caracteristicas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PlanoCargaCaracteristicas') ? [] : ['className' => PlanoCargaCaracteristicasTable::class];
        $this->PlanoCargaCaracteristicas = TableRegistry::getTableLocator()->get('PlanoCargaCaracteristicas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PlanoCargaCaracteristicas);

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
