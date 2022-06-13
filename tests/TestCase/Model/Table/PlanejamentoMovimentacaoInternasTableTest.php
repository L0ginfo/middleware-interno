<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlanejamentoMovimentacaoInternasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlanejamentoMovimentacaoInternasTable Test Case
 */
class PlanejamentoMovimentacaoInternasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlanejamentoMovimentacaoInternasTable
     */
    public $PlanejamentoMovimentacaoInternas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PlanejamentoMovimentacaoInternas',
        'app.PlanejamentoMovimentacaoProdutos',
        'app.Resvs',
        'app.Enderecos',
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
        $config = TableRegistry::getTableLocator()->exists('PlanejamentoMovimentacaoInternas') ? [] : ['className' => PlanejamentoMovimentacaoInternasTable::class];
        $this->PlanejamentoMovimentacaoInternas = TableRegistry::getTableLocator()->get('PlanejamentoMovimentacaoInternas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PlanejamentoMovimentacaoInternas);

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
