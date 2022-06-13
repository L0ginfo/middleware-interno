<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AceiteContainersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AceiteContainersTable Test Case
 */
class AceiteContainersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AceiteContainersTable
     */
    public $AceiteContainers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.AceiteContainers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AceiteContainers') ? [] : ['className' => AceiteContainersTable::class];
        $this->AceiteContainers = TableRegistry::getTableLocator()->get('AceiteContainers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AceiteContainers);

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
