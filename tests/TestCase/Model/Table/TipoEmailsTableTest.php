<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TipoEmailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TipoEmailsTable Test Case
 */
class TipoEmailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TipoEmailsTable
     */
    public $TipoEmails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TipoEmails',
        'app.Emails',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TipoEmails') ? [] : ['className' => TipoEmailsTable::class];
        $this->TipoEmails = TableRegistry::getTableLocator()->get('TipoEmails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TipoEmails);

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
