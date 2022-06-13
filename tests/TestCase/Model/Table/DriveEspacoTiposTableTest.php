<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DriveEspacoTiposTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DriveEspacoTiposTable Test Case
 */
class DriveEspacoTiposTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DriveEspacoTiposTable
     */
    public $DriveEspacoTipos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DriveEspacoTipos',
        'app.DriveEspacos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DriveEspacoTipos') ? [] : ['className' => DriveEspacoTiposTable::class];
        $this->DriveEspacoTipos = TableRegistry::getTableLocator()->get('DriveEspacoTipos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DriveEspacoTipos);

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
