<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AftnsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AftnsTable Test Case
 */
class AftnsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AftnsTable
     */
    public $Aftns;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Aftns'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Aftns') ? [] : ['className' => AftnsTable::class];
        $this->Aftns = TableRegistry::getTableLocator()->get('Aftns', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Aftns);

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
