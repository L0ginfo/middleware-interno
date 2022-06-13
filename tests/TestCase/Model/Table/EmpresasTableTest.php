<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmpresasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmpresasTable Test Case
 */
class EmpresasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmpresasTable
     */
    public $Empresas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Empresas',
        'app.Cidades',
        'app.TiposEmpresas',
        'app.Ufs',
        'app.Logradouros',
        'app.TipoServicoBancarios',
        'app.Apreensoes',
        'app.Areas',
        'app.DocumentosMercadorias',
        'app.DocumentosTransportes',
        'app.Enderecos',
        'app.EstoqueEnderecos',
        'app.Estoques',
        'app.EtiquetaProdutos',
        'app.FaturamentoArmazenagens',
        'app.FaturamentoServicos',
        'app.Faturamentos',
        'app.Funcionalidades',
        'app.LiberacoesDocumentais',
        'app.Locais',
        'app.Ncms',
        'app.OrdemServicoCarregamentos',
        'app.OrdemServicoEtiquetaCarregamentos',
        'app.OrdemServicoServexecs',
        'app.OrdemServicoTipos',
        'app.OrdemServicos',
        'app.Portarias',
        'app.Produtos',
        'app.Resvs',
        'app.TabelasPrecos',
        'app.TabelasPrecosOpcoes',
        'app.TabelasPrecosServicos',
        'app.TipoEstruturas',
        'app.UnidadeMedidas',
        'app.Usuarios'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Empresas') ? [] : ['className' => EmpresasTable::class];
        $this->Empresas = TableRegistry::getTableLocator()->get('Empresas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Empresas);

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
