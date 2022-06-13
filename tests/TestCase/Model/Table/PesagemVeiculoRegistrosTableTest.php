<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PesagemVeiculoRegistrosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PesagemVeiculoRegistrosTable Test Case
 */
class PesagemVeiculoRegistrosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PesagemVeiculoRegistrosTable
     */
    public $PesagemVeiculoRegistros;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PesagemVeiculoRegistros',
        'app.Balancas',
        'app.PesagemVeiculos',
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
        $config = TableRegistry::getTableLocator()->exists('PesagemVeiculoRegistros') ? [] : ['className' => PesagemVeiculoRegistrosTable::class];
        $this->PesagemVeiculoRegistros = TableRegistry::getTableLocator()->get('PesagemVeiculoRegistros', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PesagemVeiculoRegistros);

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
