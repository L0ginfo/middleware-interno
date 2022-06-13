<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentosMercadoriasItensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentosMercadoriasItensTable Test Case
 */
class DocumentosMercadoriasItensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentosMercadoriasItensTable
     */
    public $DocumentosMercadoriasItens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DocumentosMercadoriasItens',
        'app.Produtos',
        'app.DocumentosMercadorias',
        'app.UnidadeMedidas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DocumentosMercadoriasItens') ? [] : ['className' => DocumentosMercadoriasItensTable::class];
        $this->DocumentosMercadoriasItens = TableRegistry::getTableLocator()->get('DocumentosMercadoriasItens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DocumentosMercadoriasItens);

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
