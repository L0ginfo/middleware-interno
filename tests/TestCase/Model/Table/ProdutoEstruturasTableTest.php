<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProdutoEstruturasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProdutoEstruturasTable Test Case
 */
class ProdutoEstruturasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProdutoEstruturasTable
     */
    public $ProdutoEstruturas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ProdutoEstruturas',
        'app.Produtos',
        'app.UnidadeMedidas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ProdutoEstruturas') ? [] : ['className' => ProdutoEstruturasTable::class];
        $this->ProdutoEstruturas = TableRegistry::getTableLocator()->get('ProdutoEstruturas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProdutoEstruturas);

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
