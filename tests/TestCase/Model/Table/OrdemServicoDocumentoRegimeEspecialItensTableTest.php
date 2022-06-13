<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdemServicoDocumentoRegimeEspecialItensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdemServicoDocumentoRegimeEspecialItensTable Test Case
 */
class OrdemServicoDocumentoRegimeEspecialItensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdemServicoDocumentoRegimeEspecialItensTable
     */
    public $OrdemServicoDocumentoRegimeEspecialItens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OrdemServicoDocumentoRegimeEspecialItens',
        'app.OrdemServicos',
        'app.DocumentoRegimeEspecialAdicaoItens',
        'app.UnidadeMedidas',
        'app.Embalagens',
        'app.Produtos',
        'app.Enderecos',
        'app.StatusEstoques',
        'app.Containers',
        'app.EntradaSaidaContainers',
        'app.ControleEspecificos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OrdemServicoDocumentoRegimeEspecialItens') ? [] : ['className' => OrdemServicoDocumentoRegimeEspecialItensTable::class];
        $this->OrdemServicoDocumentoRegimeEspecialItens = TableRegistry::getTableLocator()->get('OrdemServicoDocumentoRegimeEspecialItens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrdemServicoDocumentoRegimeEspecialItens);

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
