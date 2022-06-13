<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TabelaPrecoServicoPeriodoRestricoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TabelaPrecoServicoPeriodoRestricoesTable Test Case
 */
class TabelaPrecoServicoPeriodoRestricoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TabelaPrecoServicoPeriodoRestricoesTable
     */
    public $TabelaPrecoServicoPeriodoRestricoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TabelaPrecoServicoPeriodoRestricoes',
        'app.TabelasPrecosServicos',
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
        $config = TableRegistry::getTableLocator()->exists('TabelaPrecoServicoPeriodoRestricoes') ? [] : ['className' => TabelaPrecoServicoPeriodoRestricoesTable::class];
        $this->TabelaPrecoServicoPeriodoRestricoes = TableRegistry::getTableLocator()->get('TabelaPrecoServicoPeriodoRestricoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TabelaPrecoServicoPeriodoRestricoes);

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
