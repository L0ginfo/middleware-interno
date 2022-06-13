<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EquipesTrabalhosUsuariosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EquipesTrabalhosUsuariosTable Test Case
 */
class EquipesTrabalhosUsuariosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EquipesTrabalhosUsuariosTable
     */
    public $EquipesTrabalhosUsuarios;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EquipesTrabalhosUsuarios',
        'app.EquipesTrabalhos',
        'app.Usuarios'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EquipesTrabalhosUsuarios') ? [] : ['className' => EquipesTrabalhosUsuariosTable::class];
        $this->EquipesTrabalhosUsuarios = TableRegistry::getTableLocator()->get('EquipesTrabalhosUsuarios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EquipesTrabalhosUsuarios);

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
