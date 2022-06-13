<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PesagemVeiculosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PesagemVeiculosTable Test Case
 */
class PesagemVeiculosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PesagemVeiculosTable
     */
    public $PesagemVeiculos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PesagemVeiculos',
        'app.Balancas',
        'app.Veiculos',
        'app.PesagemTipos',
        'app.Pesagens',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PesagemVeiculos') ? [] : ['className' => PesagemVeiculosTable::class];
        $this->PesagemVeiculos = TableRegistry::getTableLocator()->get('PesagemVeiculos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PesagemVeiculos);

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
