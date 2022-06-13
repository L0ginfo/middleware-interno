<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ControleProducoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ControleProducoesTable Test Case
 */
class ControleProducoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ControleProducoesTable
     */
    public $ControleProducoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ControleProducoes',
        'app.Enderecos',
        'app.Produtos',
        'app.ControleProducaoParalizacoes',
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
        $config = TableRegistry::getTableLocator()->exists('ControleProducoes') ? [] : ['className' => ControleProducoesTable::class];
        $this->ControleProducoes = TableRegistry::getTableLocator()->get('ControleProducoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ControleProducoes);

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
