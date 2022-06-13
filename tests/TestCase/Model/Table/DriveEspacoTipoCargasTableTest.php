<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DriveEspacoTipoCargasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DriveEspacoTipoCargasTable Test Case
 */
class DriveEspacoTipoCargasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DriveEspacoTipoCargasTable
     */
    public $DriveEspacoTipoCargas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DriveEspacoTipoCargas',
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
        $config = TableRegistry::getTableLocator()->exists('DriveEspacoTipoCargas') ? [] : ['className' => DriveEspacoTipoCargasTable::class];
        $this->DriveEspacoTipoCargas = TableRegistry::getTableLocator()->get('DriveEspacoTipoCargas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DriveEspacoTipoCargas);

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
