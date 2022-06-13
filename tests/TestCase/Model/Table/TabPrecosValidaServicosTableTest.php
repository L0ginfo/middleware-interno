<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TabPrecosValidaServicosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TabPrecosValidaServicosTable Test Case
 */
class TabPrecosValidaServicosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TabPrecosValidaServicosTable
     */
    public $TabPrecosValidaServicos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TabPrecosValidaServicos',
        'app.TabelasPrecosServicos',
        'app.SistemaCampos',
        'app.Operadores'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TabPrecosValidaServicos') ? [] : ['className' => TabPrecosValidaServicosTable::class];
        $this->TabPrecosValidaServicos = TableRegistry::getTableLocator()->get('TabPrecosValidaServicos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TabPrecosValidaServicos);

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
