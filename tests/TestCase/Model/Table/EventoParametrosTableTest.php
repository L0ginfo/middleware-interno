<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EventoParametrosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EventoParametrosTable Test Case
 */
class EventoParametrosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EventoParametrosTable
     */
    public $EventoParametros;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EventoParametros',
        'app.Operadores',
        'app.Eventos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EventoParametros') ? [] : ['className' => EventoParametrosTable::class];
        $this->EventoParametros = TableRegistry::getTableLocator()->get('EventoParametros', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EventoParametros);

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
