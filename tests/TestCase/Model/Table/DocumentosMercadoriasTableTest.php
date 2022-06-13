<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentosMercadoriasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentosMercadoriasTable Test Case
 */
class DocumentosMercadoriasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentosMercadoriasTable
     */
    public $DocumentosMercadorias;

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
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DocumentosMercadorias') ? [] : ['className' => DocumentosMercadoriasTable::class];
        $this->DocumentosMercadorias = TableRegistry::getTableLocator()->get('DocumentosMercadorias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DocumentosMercadorias);

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
