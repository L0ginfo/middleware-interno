<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentoRegimeEspecialDocumentoMercadoriasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentoRegimeEspecialDocumentoMercadoriasTable Test Case
 */
class DocumentoRegimeEspecialDocumentoMercadoriasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentoRegimeEspecialDocumentoMercadoriasTable
     */
    public $DocumentoRegimeEspecialDocumentoMercadorias;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DocumentoRegimeEspecialDocumentoMercadorias',
        'app.DocumentosMercadorias',
        'app.DocumentoRegimeEspeciais',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DocumentoRegimeEspecialDocumentoMercadorias') ? [] : ['className' => DocumentoRegimeEspecialDocumentoMercadoriasTable::class];
        $this->DocumentoRegimeEspecialDocumentoMercadorias = TableRegistry::getTableLocator()->get('DocumentoRegimeEspecialDocumentoMercadorias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DocumentoRegimeEspecialDocumentoMercadorias);

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
