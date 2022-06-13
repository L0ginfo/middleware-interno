<?php
namespace App\Test\TestCase\Controller;

use App\Controller\OrdemServicoDocumentoRegimeEspecialItensController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\OrdemServicoDocumentoRegimeEspecialItensController Test Case
 *
 * @uses \App\Controller\OrdemServicoDocumentoRegimeEspecialItensController
 */
class OrdemServicoDocumentoRegimeEspecialItensControllerTest extends TestCase
{
    use IntegrationTestTrait;

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
     * Test beforeRender method
     *
     * @return void
     */
    public function testBeforeRender()
    {
        $this->markTestIncomplete('Not implemented yet.');
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
