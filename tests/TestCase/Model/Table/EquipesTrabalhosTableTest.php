<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EquipesTrabalhosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EquipesTrabalhosTable Test Case
 */
class EquipesTrabalhosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EquipesTrabalhosTable
     */
    public $EquipesTrabalhos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EquipesTrabalhos',
        'app.Usuarios',
        'app.TabelasPrecos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EquipesTrabalhos') ? [] : ['className' => EquipesTrabalhosTable::class];
        $this->EquipesTrabalhos = TableRegistry::getTableLocator()->get('EquipesTrabalhos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EquipesTrabalhos);

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
