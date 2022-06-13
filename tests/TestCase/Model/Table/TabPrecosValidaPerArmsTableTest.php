<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TabPrecosValidaPerArmsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TabPrecosValidaPerArmsTable Test Case
 */
class TabPrecosValidaPerArmsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TabPrecosValidaPerArmsTable
     */
    public $TabPrecosValidaPerArms;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TabPrecosValidaPerArms',
        'app.TabelasPrecosPeriodosArms',
        'app.SistemaCampos',
        'app.Operadores'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TabPrecosValidaPerArms') ? [] : ['className' => TabPrecosValidaPerArmsTable::class];
        $this->TabPrecosValidaPerArms = TableRegistry::getTableLocator()->get('TabPrecosValidaPerArms', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TabPrecosValidaPerArms);

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
