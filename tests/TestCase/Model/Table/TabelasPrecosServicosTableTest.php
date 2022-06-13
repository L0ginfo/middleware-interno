<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TabelasPrecosServicosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TabelasPrecosServicosTable Test Case
 */
class TabelasPrecosServicosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TabelasPrecosServicosTable
     */
    public $TabelasPrecosServicos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TabelasPrecosServicos',
        'app.Empresas',
        'app.TabelasPrecos',
        'app.Servicos',
        'app.TiposValores',
        'app.SistemaCampos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TabelasPrecosServicos') ? [] : ['className' => TabelasPrecosServicosTable::class];
        $this->TabelasPrecosServicos = TableRegistry::getTableLocator()->get('TabelasPrecosServicos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TabelasPrecosServicos);

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
