<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlanejamentoSolicitacaoPesagensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlanejamentoSolicitacaoPesagensTable Test Case
 */
class PlanejamentoSolicitacaoPesagensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlanejamentoSolicitacaoPesagensTable
     */
    public $PlanejamentoSolicitacaoPesagens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PlanejamentoSolicitacaoPesagens',
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
        $config = TableRegistry::getTableLocator()->exists('PlanejamentoSolicitacaoPesagens') ? [] : ['className' => PlanejamentoSolicitacaoPesagensTable::class];
        $this->PlanejamentoSolicitacaoPesagens = TableRegistry::getTableLocator()->get('PlanejamentoSolicitacaoPesagens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PlanejamentoSolicitacaoPesagens);

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
