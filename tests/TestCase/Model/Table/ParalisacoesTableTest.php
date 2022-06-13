<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ParalisacoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ParalisacoesTable Test Case
 */
class ParalisacoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ParalisacoesTable
     */
    public $Paralisacoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Paralisacoes',
        'app.ParalisacaoMotivos',
        'app.PlanejamentoMaritimos',
        'app.PlanoCargas',
        'app.PlanoCargaPoroes',
        'app.Poroes',
        'app.PlanoCargaTipoMercadorias',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Paralisacoes') ? [] : ['className' => ParalisacoesTable::class];
        $this->Paralisacoes = TableRegistry::getTableLocator()->get('Paralisacoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Paralisacoes);

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
