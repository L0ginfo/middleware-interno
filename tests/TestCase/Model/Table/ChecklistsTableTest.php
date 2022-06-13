<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChecklistsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChecklistsTable Test Case
 */
class ChecklistsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ChecklistsTable
     */
    public $Checklists;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Checklists',
        'app.ChecklistTipos',
        'app.ChecklistPerguntas',
        'app.ChecklistResvs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Checklists') ? [] : ['className' => ChecklistsTable::class];
        $this->Checklists = TableRegistry::getTableLocator()->get('Checklists', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Checklists);

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
