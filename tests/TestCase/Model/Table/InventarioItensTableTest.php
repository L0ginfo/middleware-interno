<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InventarioItensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InventarioItensTable Test Case
 */
class InventarioItensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InventarioItensTable
     */
    public $InventarioItens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.InventarioItens',
        'app.Inventarios',
        'app.Enderecos',
        'app.EtiquetaProdutos',
        'app.Operadores',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('InventarioItens') ? [] : ['className' => InventarioItensTable::class];
        $this->InventarioItens = TableRegistry::getTableLocator()->get('InventarioItens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InventarioItens);

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
