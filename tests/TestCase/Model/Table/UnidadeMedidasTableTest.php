<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UnidadeMedidasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UnidadeMedidasTable Test Case
 */
class UnidadeMedidasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UnidadeMedidasTable
     */
    public $UnidadeMedidas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.UnidadeMedidas',
        'app.Empresas',
        'app.EstoqueEnderecos',
        'app.Estoques',
        'app.EtiquetaProdutos',
        'app.Produtos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('UnidadeMedidas') ? [] : ['className' => UnidadeMedidasTable::class];
        $this->UnidadeMedidas = TableRegistry::getTableLocator()->get('UnidadeMedidas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UnidadeMedidas);

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
