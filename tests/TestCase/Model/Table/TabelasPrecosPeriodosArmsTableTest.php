<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TabelasPrecosPeriodosArmsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TabelasPrecosPeriodosArmsTable Test Case
 */
class TabelasPrecosPeriodosArmsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TabelasPrecosPeriodosArmsTable
     */
    public $TabelasPrecosPeriodosArms;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TabelasPrecosPeriodosArms',
        'app.TabelasPrecos',
        'app.SistemaCampos',
        'app.Servicos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TabelasPrecosPeriodosArms') ? [] : ['className' => TabelasPrecosPeriodosArmsTable::class];
        $this->TabelasPrecosPeriodosArms = TableRegistry::getTableLocator()->get('TabelasPrecosPeriodosArms', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TabelasPrecosPeriodosArms);

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
