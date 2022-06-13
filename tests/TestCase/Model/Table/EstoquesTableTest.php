<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EstoquesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EstoquesTable Test Case
 */
class EstoquesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EstoquesTable
     */
    public $Estoques;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Estoques',
        'app.UnidadeMedidas',
        'app.Empresas',
        'app.EstoqueEnderecos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Estoques') ? [] : ['className' => EstoquesTable::class];
        $this->Estoques = TableRegistry::getTableLocator()->get('Estoques', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Estoques);

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
