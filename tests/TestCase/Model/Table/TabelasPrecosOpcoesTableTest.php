<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TabelasPrecosOpcoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TabelasPrecosOpcoesTable Test Case
 */
class TabelasPrecosOpcoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TabelasPrecosOpcoesTable
     */
    public $TabelasPrecosOpcoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TabelasPrecosOpcoes',
        'app.TabelasPrecos',
        'app.TiposEmpresas',
        'app.Empresas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TabelasPrecosOpcoes') ? [] : ['className' => TabelasPrecosOpcoesTable::class];
        $this->TabelasPrecosOpcoes = TableRegistry::getTableLocator()->get('TabelasPrecosOpcoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TabelasPrecosOpcoes);

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
