<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FormacaoLoteItensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FormacaoLoteItensTable Test Case
 */
class FormacaoLoteItensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FormacaoLoteItensTable
     */
    public $FormacaoLoteItens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FormacaoLoteItens',
        'app.FormacaoLotes',
        'app.OrdemServicos',
        'app.UnidadeMedidas',
        'app.DocumentosMercadoriasItens',
        'app.Embalagens',
        'app.Produtos',
        'app.Enderecos',
        'app.StatusEstoques',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FormacaoLoteItens') ? [] : ['className' => FormacaoLoteItensTable::class];
        $this->FormacaoLoteItens = TableRegistry::getTableLocator()->get('FormacaoLoteItens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FormacaoLoteItens);

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
