<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentoRegimeEspecialAdicoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentoRegimeEspecialAdicoesTable Test Case
 */
class DocumentoRegimeEspecialAdicoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentoRegimeEspecialAdicoesTable
     */
    public $DocumentoRegimeEspecialAdicoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DocumentoRegimeEspecialAdicoes',
        'app.UnidadeMedidas',
        'app.Produtos',
        'app.Containers',
        'app.DocumentoRegimeEspeciais',
        'app.Empresas',
        'app.DocumentoRegimeEspecialAdicaoItens',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DocumentoRegimeEspecialAdicoes') ? [] : ['className' => DocumentoRegimeEspecialAdicoesTable::class];
        $this->DocumentoRegimeEspecialAdicoes = TableRegistry::getTableLocator()->get('DocumentoRegimeEspecialAdicoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DocumentoRegimeEspecialAdicoes);

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
