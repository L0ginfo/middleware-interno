<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EstoqueEnderecoReservasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EstoqueEnderecoReservasTable Test Case
 */
class EstoqueEnderecoReservasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EstoqueEnderecoReservasTable
     */
    public $EstoqueEnderecoReservas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EstoqueEnderecoReservas',
        'app.UnidadeMedidas',
        'app.Enderecos',
        'app.Estoques',
        'app.Empresas',
        'app.Produtos',
        'app.OrdemServicos',
        'app.EstoqueEnderecos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EstoqueEnderecoReservas') ? [] : ['className' => EstoqueEnderecoReservasTable::class];
        $this->EstoqueEnderecoReservas = TableRegistry::getTableLocator()->get('EstoqueEnderecoReservas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EstoqueEnderecoReservas);

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
