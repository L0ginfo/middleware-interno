<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdemServicoUnitizacoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdemServicoUnitizacoesTable Test Case
 */
class OrdemServicoUnitizacoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdemServicoUnitizacoesTable
     */
    public $OrdemServicoUnitizacoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OrdemServicoUnitizacoes',
        'app.OrdemServicos',
        'app.UnidadeMedidas',
        'app.DocumentosMercadoriasItens',
        'app.Embalagens',
        'app.Produtos',
        'app.Enderecos',
        'app.StatusEstoques',
        'app.Containers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OrdemServicoUnitizacoes') ? [] : ['className' => OrdemServicoUnitizacoesTable::class];
        $this->OrdemServicoUnitizacoes = TableRegistry::getTableLocator()->get('OrdemServicoUnitizacoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrdemServicoUnitizacoes);

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
