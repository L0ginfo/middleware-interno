<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\QueueEmailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\QueueEmailsTable Test Case
 */
class QueueEmailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\QueueEmailsTable
     */
    public $QueueEmails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.QueueEmails',
        'app.Emails',
        'app.Users',
        'app.QueueEmailAnexos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('QueueEmails') ? [] : ['className' => QueueEmailsTable::class];
        $this->QueueEmails = TableRegistry::getTableLocator()->get('QueueEmails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->QueueEmails);

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
