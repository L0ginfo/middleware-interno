<?php
namespace App\Test\TestCase\Controller;

use App\Controller\EmpresasController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\EmpresasController Test Case
 *
 * @uses \App\Controller\EmpresasController
 */
class EmpresasControllerTest extends TestCase
{
    use IntegrationTestTrait;

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
        'app.Usuarios',
        'app.EmpresasUsuarios'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
