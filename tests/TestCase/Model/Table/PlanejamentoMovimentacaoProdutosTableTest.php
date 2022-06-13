<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlanejamentoMovimentacaoProdutosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlanejamentoMovimentacaoProdutosTable Test Case
 */
class PlanejamentoMovimentacaoProdutosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlanejamentoMovimentacaoProdutosTable
     */
    public $PlanejamentoMovimentacaoProdutos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PlanejamentoMovimentacaoProdutos',
        'app.Produtos',
        'app.Operacoes',
        'app.Enderecos',
        'app.ControleProducoes',
        'app.PlanejamentoMovimentacaoInternas',
        'app.PlanejamentoMovimentacaoVeiculos',
        'app.PlanejamentoSolicitacaoPesagens',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PlanejamentoMovimentacaoProdutos') ? [] : ['className' => PlanejamentoMovimentacaoProdutosTable::class];
        $this->PlanejamentoMovimentacaoProdutos = TableRegistry::getTableLocator()->get('PlanejamentoMovimentacaoProdutos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PlanejamentoMovimentacaoProdutos);

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
