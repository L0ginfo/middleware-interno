<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FaturamentoAdicoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FaturamentoAdicoesTable Test Case
 */
class FaturamentoAdicoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FaturamentoAdicoesTable
     */
    public $FaturamentoAdicoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FaturamentoAdicoes',
        'app.LiberacaoDocumentalDecisaoTabelaPrecoAdicoes',
        'app.Faturamentos',
        'app.TabelasPrecos',
        'app.TabelasPrecosPeriodosArms',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FaturamentoAdicoes') ? [] : ['className' => FaturamentoAdicoesTable::class];
        $this->FaturamentoAdicoes = TableRegistry::getTableLocator()->get('FaturamentoAdicoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FaturamentoAdicoes);

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
