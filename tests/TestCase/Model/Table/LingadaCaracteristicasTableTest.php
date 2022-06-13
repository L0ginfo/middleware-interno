<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LingadaCaracteristicasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LingadaCaracteristicasTable Test Case
 */
class LingadaCaracteristicasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LingadaCaracteristicasTable
     */
    public $LingadaCaracteristicas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.LingadaCaracteristicas',
        'app.PlanoCargaCaracteristicas',
        'app.OrdemServicoItemLingadas',
        'app.Caracteristicas',
        'app.PlanoCargaPoraoCaracteristicas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LingadaCaracteristicas') ? [] : ['className' => LingadaCaracteristicasTable::class];
        $this->LingadaCaracteristicas = TableRegistry::getTableLocator()->get('LingadaCaracteristicas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LingadaCaracteristicas);

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
