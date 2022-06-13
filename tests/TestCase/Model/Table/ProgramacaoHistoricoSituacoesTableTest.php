<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProgramacaoHistoricoSituacoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProgramacaoHistoricoSituacoesTable Test Case
 */
class ProgramacaoHistoricoSituacoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProgramacaoHistoricoSituacoesTable
     */
    public $ProgramacaoHistoricoSituacoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ProgramacaoHistoricoSituacoes',
        'app.Programacoes',
        'app.ProgramacaoSituacoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ProgramacaoHistoricoSituacoes') ? [] : ['className' => ProgramacaoHistoricoSituacoesTable::class];
        $this->ProgramacaoHistoricoSituacoes = TableRegistry::getTableLocator()->get('ProgramacaoHistoricoSituacoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProgramacaoHistoricoSituacoes);

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
