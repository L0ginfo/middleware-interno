<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PortoTrabalhoPeriodosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PortoTrabalhoPeriodosTable Test Case
 */
class PortoTrabalhoPeriodosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PortoTrabalhoPeriodosTable
     */
    public $PortoTrabalhoPeriodos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PortoTrabalhoPeriodos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PortoTrabalhoPeriodos') ? [] : ['className' => PortoTrabalhoPeriodosTable::class];
        $this->PortoTrabalhoPeriodos = TableRegistry::getTableLocator()->get('PortoTrabalhoPeriodos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PortoTrabalhoPeriodos);

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
