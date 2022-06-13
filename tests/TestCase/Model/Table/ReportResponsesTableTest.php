<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReportResponsesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReportResponsesTable Test Case
 */
class ReportResponsesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ReportResponsesTable
     */
    public $ReportResponses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ReportResponses',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ReportResponses') ? [] : ['className' => ReportResponsesTable::class];
        $this->ReportResponses = TableRegistry::getTableLocator()->get('ReportResponses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ReportResponses);

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
