<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlanoCargaDocumentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlanoCargaDocumentosTable Test Case
 */
class PlanoCargaDocumentosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlanoCargaDocumentosTable
     */
    public $PlanoCargaDocumentos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PlanoCargaDocumentos',
        'app.PlanoCargas',
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
        $config = TableRegistry::getTableLocator()->exists('PlanoCargaDocumentos') ? [] : ['className' => PlanoCargaDocumentosTable::class];
        $this->PlanoCargaDocumentos = TableRegistry::getTableLocator()->get('PlanoCargaDocumentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PlanoCargaDocumentos);

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
