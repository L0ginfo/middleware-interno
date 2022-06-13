<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CredenciamentoVeiculosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CredenciamentoVeiculosTable Test Case
 */
class CredenciamentoVeiculosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CredenciamentoVeiculosTable
     */
    public $CredenciamentoVeiculos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CredenciamentoVeiculos',
        'app.Empresas',
        'app.Veiculos',
        'app.PessoaVeiculos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CredenciamentoVeiculos') ? [] : ['className' => CredenciamentoVeiculosTable::class];
        $this->CredenciamentoVeiculos = TableRegistry::getTableLocator()->get('CredenciamentoVeiculos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CredenciamentoVeiculos);

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
