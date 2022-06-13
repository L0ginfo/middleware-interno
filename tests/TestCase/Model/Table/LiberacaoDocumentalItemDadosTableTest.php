<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LiberacaoDocumentalItemDadosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LiberacaoDocumentalItemDadosTable Test Case
 */
class LiberacaoDocumentalItemDadosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LiberacaoDocumentalItemDadosTable
     */
    public $LiberacaoDocumentalItemDados;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.LiberacaoDocumentalItemDados',
        'app.LiberacaoDocumentais',
        'app.RegimeAduaneiros',
        'app.Estoques',
        'app.TabelaPrecos',
        'app.UnidadeMedidas',
        'app.Enderecos',
        'app.Empresas',
        'app.Produtos',
        'app.Containers',
        'app.EntradaSaidaContainers',
        'app.Procedencias',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LiberacaoDocumentalItemDados') ? [] : ['className' => LiberacaoDocumentalItemDadosTable::class];
        $this->LiberacaoDocumentalItemDados = TableRegistry::getTableLocator()->get('LiberacaoDocumentalItemDados', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LiberacaoDocumentalItemDados);

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
