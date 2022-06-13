<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProgramacaoDriveEspacosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProgramacaoDriveEspacosTable Test Case
 */
class ProgramacaoDriveEspacosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProgramacaoDriveEspacosTable
     */
    public $ProgramacaoDriveEspacos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ProgramacaoDriveEspacos',
        'app.DriveEspacos',
        'app.Programacoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ProgramacaoDriveEspacos') ? [] : ['className' => ProgramacaoDriveEspacosTable::class];
        $this->ProgramacaoDriveEspacos = TableRegistry::getTableLocator()->get('ProgramacaoDriveEspacos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProgramacaoDriveEspacos);

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
