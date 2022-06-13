<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlanejamentoMovimentacaoVeiculosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlanejamentoMovimentacaoVeiculosTable Test Case
 */
class PlanejamentoMovimentacaoVeiculosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlanejamentoMovimentacaoVeiculosTable
     */
    public $PlanejamentoMovimentacaoVeiculos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PlanejamentoMovimentacaoVeiculos',
        'app.Veiculos',
        'app.PlanejamentoMovimentacaoProdutos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PlanejamentoMovimentacaoVeiculos') ? [] : ['className' => PlanejamentoMovimentacaoVeiculosTable::class];
        $this->PlanejamentoMovimentacaoVeiculos = TableRegistry::getTableLocator()->get('PlanejamentoMovimentacaoVeiculos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PlanejamentoMovimentacaoVeiculos);

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
