<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlanoCargaPackingListsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlanoCargaPackingListsTable Test Case
 */
class PlanoCargaPackingListsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlanoCargaPackingListsTable
     */
    public $PlanoCargaPackingLists;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PlanoCargaPackingLists',
        'app.PlanoCargas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PlanoCargaPackingLists') ? [] : ['className' => PlanoCargaPackingListsTable::class];
        $this->PlanoCargaPackingLists = TableRegistry::getTableLocator()->get('PlanoCargaPackingLists', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PlanoCargaPackingLists);

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
