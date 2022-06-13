<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SmtpsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SmtpsTable Test Case
 */
class SmtpsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SmtpsTable
     */
    public $Smtps;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Smtps',
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
        $config = TableRegistry::getTableLocator()->exists('Smtps') ? [] : ['className' => SmtpsTable::class];
        $this->Smtps = TableRegistry::getTableLocator()->get('Smtps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Smtps);

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
