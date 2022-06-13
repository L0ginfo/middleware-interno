<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RfbPerfisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RfbPerfisTable Test Case
 */
class RfbPerfisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RfbPerfisTable
     */
    public $RfbPerfis;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.RfbPerfis',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RfbPerfis') ? [] : ['className' => RfbPerfisTable::class];
        $this->RfbPerfis = TableRegistry::getTableLocator()->get('RfbPerfis', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RfbPerfis);

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
