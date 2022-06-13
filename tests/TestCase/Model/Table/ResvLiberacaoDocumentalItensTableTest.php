<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResvLiberacaoDocumentalItensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResvLiberacaoDocumentalItensTable Test Case
 */
class ResvLiberacaoDocumentalItensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ResvLiberacaoDocumentalItensTable
     */
    public $ResvLiberacaoDocumentalItens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ResvLiberacaoDocumentalItens',
        'app.ResvsLiberacoesDocumentais',
        'app.LiberacoesDocumentaisItens',
        'app.LiberacaoDocumentalTransportadoraItens',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ResvLiberacaoDocumentalItens') ? [] : ['className' => ResvLiberacaoDocumentalItensTable::class];
        $this->ResvLiberacaoDocumentalItens = TableRegistry::getTableLocator()->get('ResvLiberacaoDocumentalItens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResvLiberacaoDocumentalItens);

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
