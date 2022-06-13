<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FaturamentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FaturamentosTable Test Case
 */
class FaturamentosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FaturamentosTable
     */
    public $Faturamentos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Faturamentos',
        'app.FormaPagamentos',
        'app.LiberacoesDocumentais',
        'app.TabelasPrecos',
        'app.RegimesAduaneiros',
        'app.Empresas',
        'app.TiposFaturamentos',
        'app.FaturamentoArmazenagens',
        'app.FaturamentoBaixas',
        'app.FaturamentoServicos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Faturamentos') ? [] : ['className' => FaturamentosTable::class];
        $this->Faturamentos = TableRegistry::getTableLocator()->get('Faturamentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Faturamentos);

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
