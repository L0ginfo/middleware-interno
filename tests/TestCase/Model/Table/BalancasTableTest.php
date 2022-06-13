<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BalancasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BalancasTable Test Case
 */
class BalancasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BalancasTable
     */
    public $Balancas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Balancas',
        'app.TipoBalancas',
        'app.Portarias',
        'app.Cancelas',
        'app.EntradaSaidaFluxos',
        'app.PesagemVeiculoRegistros',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Balancas') ? [] : ['className' => BalancasTable::class];
        $this->Balancas = TableRegistry::getTableLocator()->get('Balancas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Balancas);

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
