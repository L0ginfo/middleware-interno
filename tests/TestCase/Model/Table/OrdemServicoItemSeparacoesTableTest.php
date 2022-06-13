<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdemServicoItemSeparacoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdemServicoItemSeparacoesTable Test Case
 */
class OrdemServicoItemSeparacoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdemServicoItemSeparacoesTable
     */
    public $OrdemServicoItemSeparacoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OrdemServicoItemSeparacoes',
        'app.UnidadeMedidas',
        'app.Enderecos',
        'app.EnderecoSeparacao',
        'app.Estoques',
        'app.Empresas',
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
        $config = TableRegistry::getTableLocator()->exists('OrdemServicoItemSeparacoes') ? [] : ['className' => OrdemServicoItemSeparacoesTable::class];
        $this->OrdemServicoItemSeparacoes = TableRegistry::getTableLocator()->get('OrdemServicoItemSeparacoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrdemServicoItemSeparacoes);

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
