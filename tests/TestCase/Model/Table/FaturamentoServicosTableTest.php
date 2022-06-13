<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FaturamentoServicosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FaturamentoServicosTable Test Case
 */
class FaturamentoServicosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FaturamentoServicosTable
     */
    public $FaturamentoServicos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FaturamentoServicos',
        'app.TabelasPrecosServicos',
        'app.Faturamentos',
        'app.Empresas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FaturamentoServicos') ? [] : ['className' => FaturamentoServicosTable::class];
        $this->FaturamentoServicos = TableRegistry::getTableLocator()->get('FaturamentoServicos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FaturamentoServicos);

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
