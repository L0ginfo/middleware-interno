<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BloqueioContainersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BloqueioContainersTable Test Case
 */
class BloqueioContainersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BloqueioContainersTable
     */
    public $BloqueioContainers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.BloqueioContainers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('BloqueioContainers') ? [] : ['className' => BloqueioContainersTable::class];
        $this->BloqueioContainers = TableRegistry::getTableLocator()->get('BloqueioContainers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BloqueioContainers);

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
