<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentosTransportesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentosTransportesTable Test Case
 */
class DocumentosTransportesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentosTransportesTable
     */
    public $DocumentosTransportes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DocumentosTransportes',
        'app.Modais',
        'app.Empresas',
        'app.TipoDocumentos',
        'app.Resvs',
        'app.ResvsDocumentosTransportes',
        'app.DocumentosMercadorias',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DocumentosTransportes') ? [] : ['className' => DocumentosTransportesTable::class];
        $this->DocumentosTransportes = TableRegistry::getTableLocator()->get('DocumentosTransportes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DocumentosTransportes);

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
