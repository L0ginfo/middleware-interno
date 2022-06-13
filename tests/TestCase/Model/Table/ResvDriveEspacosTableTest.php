<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResvDriveEspacosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResvDriveEspacosTable Test Case
 */
class ResvDriveEspacosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ResvDriveEspacosTable
     */
    public $ResvDriveEspacos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ResvDriveEspacos',
        'app.DriveEspacos',
        'app.Resvs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ResvDriveEspacos') ? [] : ['className' => ResvDriveEspacosTable::class];
        $this->ResvDriveEspacos = TableRegistry::getTableLocator()->get('ResvDriveEspacos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResvDriveEspacos);

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
