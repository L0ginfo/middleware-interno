<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RfbStatusTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RfbStatusTable Test Case
 */
class RfbStatusTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RfbStatusTable
     */
    public $RfbStatus;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.RfbStatus',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RfbStatus') ? [] : ['className' => RfbStatusTable::class];
        $this->RfbStatus = TableRegistry::getTableLocator()->get('RfbStatus', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RfbStatus);

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
