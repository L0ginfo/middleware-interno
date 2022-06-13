<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FormacaoCargaNfPedidosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FormacaoCargaNfPedidosTable Test Case
 */
class FormacaoCargaNfPedidosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FormacaoCargaNfPedidosTable
     */
    public $FormacaoCargaNfPedidos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FormacaoCargaNfPedidos',
        'app.FormacaoCargas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FormacaoCargaNfPedidos') ? [] : ['className' => FormacaoCargaNfPedidosTable::class];
        $this->FormacaoCargaNfPedidos = TableRegistry::getTableLocator()->get('FormacaoCargaNfPedidos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FormacaoCargaNfPedidos);

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
