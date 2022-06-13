<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdemServicoTemperaturasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdemServicoTemperaturasTable Test Case
 */
class OrdemServicoTemperaturasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdemServicoTemperaturasTable
     */
    public $OrdemServicoTemperaturas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OrdemServicoTemperaturas',
        'app.EntradaSaidaContainers',
        'app.Enderecos',
        'app.UnidadeMedidas',
        'app.Produtos',
        'app.OrdemServicos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OrdemServicoTemperaturas') ? [] : ['className' => OrdemServicoTemperaturasTable::class];
        $this->OrdemServicoTemperaturas = TableRegistry::getTableLocator()->get('OrdemServicoTemperaturas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrdemServicoTemperaturas);

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
