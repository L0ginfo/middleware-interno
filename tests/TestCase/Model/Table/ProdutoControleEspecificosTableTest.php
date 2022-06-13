<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProdutoControleEspecificosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProdutoControleEspecificosTable Test Case
 */
class ProdutoControleEspecificosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProdutoControleEspecificosTable
     */
    public $ProdutoControleEspecificos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ProdutoControleEspecificos',
        'app.ControleEspecificos',
        'app.Produtos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ProdutoControleEspecificos') ? [] : ['className' => ProdutoControleEspecificosTable::class];
        $this->ProdutoControleEspecificos = TableRegistry::getTableLocator()->get('ProdutoControleEspecificos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProdutoControleEspecificos);

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
