<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentoRegimeEspecialAdicaoItensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentoRegimeEspecialAdicaoItensTable Test Case
 */
class DocumentoRegimeEspecialAdicaoItensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentoRegimeEspecialAdicaoItensTable
     */
    public $DocumentoRegimeEspecialAdicaoItens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DocumentoRegimeEspecialAdicaoItens',
        'app.UnidadeMedidas',
        'app.Produtos',
        'app.Containers',
        'app.DocumentoRegimeEspeciais',
        'app.DocumentoRegimeEspecialAdicoes',
        'app.Empresas',
        'app.Moedas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DocumentoRegimeEspecialAdicaoItens') ? [] : ['className' => DocumentoRegimeEspecialAdicaoItensTable::class];
        $this->DocumentoRegimeEspecialAdicaoItens = TableRegistry::getTableLocator()->get('DocumentoRegimeEspecialAdicaoItens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DocumentoRegimeEspecialAdicaoItens);

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
