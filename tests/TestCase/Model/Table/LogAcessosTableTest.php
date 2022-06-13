<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LogAcessosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LogAcessosTable Test Case
 */
class LogAcessosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LogAcessosTable
     */
    public $LogAcessos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.LogAcessos',
        'app.Usuarios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LogAcessos') ? [] : ['className' => LogAcessosTable::class];
        $this->LogAcessos = TableRegistry::getTableLocator()->get('LogAcessos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LogAcessos);

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
