<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TipoDocumentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TipoDocumentosTable Test Case
 */
class TipoDocumentosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TipoDocumentosTable
     */
    public $TipoDocumentos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TipoDocumentos',
        'app.DocumentosMercadorias',
        'app.DocumentosTransportes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TipoDocumentos') ? [] : ['className' => TipoDocumentosTable::class];
        $this->TipoDocumentos = TableRegistry::getTableLocator()->get('TipoDocumentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TipoDocumentos);

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
}
