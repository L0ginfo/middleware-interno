<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProdutoClassificacaoVinculosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProdutoClassificacaoVinculosTable Test Case
 */
class ProdutoClassificacaoVinculosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProdutoClassificacaoVinculosTable
     */
    public $ProdutoClassificacaoVinculos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ProdutoClassificacaoVinculos',
        'app.ProdutoClassificacoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ProdutoClassificacaoVinculos') ? [] : ['className' => ProdutoClassificacaoVinculosTable::class];
        $this->ProdutoClassificacaoVinculos = TableRegistry::getTableLocator()->get('ProdutoClassificacaoVinculos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProdutoClassificacaoVinculos);

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
