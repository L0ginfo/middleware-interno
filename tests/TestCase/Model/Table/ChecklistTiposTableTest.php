<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChecklistTiposTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChecklistTiposTable Test Case
 */
class ChecklistTiposTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ChecklistTiposTable
     */
    public $ChecklistTipos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ChecklistTipos',
        'app.Checklists',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ChecklistTipos') ? [] : ['className' => ChecklistTiposTable::class];
        $this->ChecklistTipos = TableRegistry::getTableLocator()->get('ChecklistTipos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ChecklistTipos);

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
