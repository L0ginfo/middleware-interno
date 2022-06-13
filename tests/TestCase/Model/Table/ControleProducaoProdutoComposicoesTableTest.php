<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ControleProducaoProdutoComposicoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ControleProducaoProdutoComposicoesTable Test Case
 */
class ControleProducaoProdutoComposicoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ControleProducaoProdutoComposicoesTable
     */
    public $ControleProducaoProdutoComposicoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ControleProducaoProdutoComposicoes',
        'app.ControleProducoes',
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
        $config = TableRegistry::getTableLocator()->exists('ControleProducaoProdutoComposicoes') ? [] : ['className' => ControleProducaoProdutoComposicoesTable::class];
        $this->ControleProducaoProdutoComposicoes = TableRegistry::getTableLocator()->get('ControleProducaoProdutoComposicoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ControleProducaoProdutoComposicoes);

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
