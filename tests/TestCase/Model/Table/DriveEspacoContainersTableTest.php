<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DriveEspacoContainersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DriveEspacoContainersTable Test Case
 */
class DriveEspacoContainersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DriveEspacoContainersTable
     */
    public $DriveEspacoContainers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DriveEspacoContainers',
        'app.DriveEspacos',
        'app.Containers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DriveEspacoContainers') ? [] : ['className' => DriveEspacoContainersTable::class];
        $this->DriveEspacoContainers = TableRegistry::getTableLocator()->get('DriveEspacoContainers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DriveEspacoContainers);

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
