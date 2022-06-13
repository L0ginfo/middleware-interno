<?php
namespace App\Test\TestCase\Controller;

use App\Controller\FaturamentosController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\FaturamentosController Test Case
 *
 * @uses \App\Controller\FaturamentosController
 */
class FaturamentosControllerTest extends TestCase
{
    use IntegrationTestTrait;

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
