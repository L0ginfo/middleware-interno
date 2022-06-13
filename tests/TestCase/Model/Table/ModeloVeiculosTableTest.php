<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ModeloVeiculosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ModeloVeiculosTable Test Case
 */
class ModeloVeiculosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ModeloVeiculosTable
     */
    public $ModeloVeiculos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ModeloVeiculos',
        'app.Veiculos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ModeloVeiculos') ? [] : ['className' => ModeloVeiculosTable::class];
        $this->ModeloVeiculos = TableRegistry::getTableLocator()->get('ModeloVeiculos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ModeloVeiculos);

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
}
