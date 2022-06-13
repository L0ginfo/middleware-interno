<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentoMercadoriaItemControleEspecificosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentoMercadoriaItemControleEspecificosTable Test Case
 */
class DocumentoMercadoriaItemControleEspecificosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentoMercadoriaItemControleEspecificosTable
     */
    public $DocumentoMercadoriaItemControleEspecificos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DocumentoMercadoriaItemControleEspecificos',
        'app.ControleEspecificos',
        'app.DocumentosMercadoriasItens',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DocumentoMercadoriaItemControleEspecificos') ? [] : ['className' => DocumentoMercadoriaItemControleEspecificosTable::class];
        $this->DocumentoMercadoriaItemControleEspecificos = TableRegistry::getTableLocator()->get('DocumentoMercadoriaItemControleEspecificos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DocumentoMercadoriaItemControleEspecificos);

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
