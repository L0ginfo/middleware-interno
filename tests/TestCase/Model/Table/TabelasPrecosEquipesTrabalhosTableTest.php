<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TabelasPrecosEquipesTrabalhosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TabelasPrecosEquipesTrabalhosTable Test Case
 */
class TabelasPrecosEquipesTrabalhosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TabelasPrecosEquipesTrabalhosTable
     */
    public $TabelasPrecosEquipesTrabalhos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TabelasPrecosEquipesTrabalhos',
        'app.TabelasPrecos',
        'app.EquipesTrabalhos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TabelasPrecosEquipesTrabalhos') ? [] : ['className' => TabelasPrecosEquipesTrabalhosTable::class];
        $this->TabelasPrecosEquipesTrabalhos = TableRegistry::getTableLocator()->get('TabelasPrecosEquipesTrabalhos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TabelasPrecosEquipesTrabalhos);

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
