<?php
namespace App\Test\TestCase\Controller;

use App\Controller\PlanejamentoMaritimosController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\PlanejamentoMaritimosController Test Case
 *
 * @uses \App\Controller\PlanejamentoMaritimosController
 */
class PlanejamentoMaritimosControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PlanejamentoMaritimos',
        'app.SituacaoProgramacaoMaritimas',
        'app.Empresas',
        'app.Bercos',
        'app.Veiculos',
        'app.Ncms',
        'app.TiposCargas',
        'app.TiposViagens',
        'app.Sentidos',
        'app.Procedencias',
        'app.Eventos',
        'app.PlanejamentoMaritimosEventos'
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
