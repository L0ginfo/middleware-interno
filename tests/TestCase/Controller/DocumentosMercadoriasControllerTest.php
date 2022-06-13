<?php
namespace App\Test\TestCase\Controller;

use App\Controller\DocumentosMercadoriasController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\DocumentosMercadoriasController Test Case
 *
 * @uses \App\Controller\DocumentosMercadoriasController
 */
class DocumentosMercadoriasControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DocumentosMercadorias',
        'app.Modais',
        'app.Empresas',
        'app.RegimesAduaneiros',
        'app.Moedas',
        'app.DocumentosTransportes',
        'app.Pais',
        'app.NaturezasCargas',
        'app.TratamentosCargas',
        'app.TiposDocumentos'
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
