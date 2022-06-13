<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TernosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TernosTable Test Case
 */
class TernosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TernosTable
     */
    public $Ternos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Ternos',
        'app.PlanoCargaPoroes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Ternos') ? [] : ['className' => TernosTable::class];
        $this->Ternos = TableRegistry::getTableLocator()->get('Ternos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Ternos);

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
