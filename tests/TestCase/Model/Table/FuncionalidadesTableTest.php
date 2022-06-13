<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FuncionalidadesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FuncionalidadesTable Test Case
 */
class FuncionalidadesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FuncionalidadesTable
     */
    public $Funcionalidades;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Funcionalidades',
        'app.Empresas',
        'app.Areas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Funcionalidades') ? [] : ['className' => FuncionalidadesTable::class];
        $this->Funcionalidades = TableRegistry::getTableLocator()->get('Funcionalidades', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Funcionalidades);

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
