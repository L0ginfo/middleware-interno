<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlanejamentoMaritimoTernoPeriodosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlanejamentoMaritimoTernoPeriodosTable Test Case
 */
class PlanejamentoMaritimoTernoPeriodosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlanejamentoMaritimoTernoPeriodosTable
     */
    public $PlanejamentoMaritimoTernoPeriodos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PlanejamentoMaritimoTernoPeriodos',
        'app.PlanejamentoMaritimoTernos',
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
        $config = TableRegistry::getTableLocator()->exists('PlanejamentoMaritimoTernoPeriodos') ? [] : ['className' => PlanejamentoMaritimoTernoPeriodosTable::class];
        $this->PlanejamentoMaritimoTernoPeriodos = TableRegistry::getTableLocator()->get('PlanejamentoMaritimoTernoPeriodos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PlanejamentoMaritimoTernoPeriodos);

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
