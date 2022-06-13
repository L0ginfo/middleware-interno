<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CamerasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CamerasTable Test Case
 */
class CamerasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CamerasTable
     */
    public $Cameras;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Cameras',
        'app.Georreferenciamentos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Cameras') ? [] : ['className' => CamerasTable::class];
        $this->Cameras = TableRegistry::getTableLocator()->get('Cameras', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cameras);

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
