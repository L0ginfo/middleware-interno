<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PoroesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PoroesTable Test Case
 */
class PoroesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PoroesTable
     */
    public $Poroes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Poroes',
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
        $config = TableRegistry::getTableLocator()->exists('Poroes') ? [] : ['className' => PoroesTable::class];
        $this->Poroes = TableRegistry::getTableLocator()->get('Poroes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Poroes);

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
