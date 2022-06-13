<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProgramacaoLiberacaoDocumentalItensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProgramacaoLiberacaoDocumentalItensTable Test Case
 */
class ProgramacaoLiberacaoDocumentalItensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProgramacaoLiberacaoDocumentalItensTable
     */
    public $ProgramacaoLiberacaoDocumentalItens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ProgramacaoLiberacaoDocumentalItens',
        'app.ProgramacaoLiberacaoDocumentais',
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
        $config = TableRegistry::getTableLocator()->exists('ProgramacaoLiberacaoDocumentalItens') ? [] : ['className' => ProgramacaoLiberacaoDocumentalItensTable::class];
        $this->ProgramacaoLiberacaoDocumentalItens = TableRegistry::getTableLocator()->get('ProgramacaoLiberacaoDocumentalItens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProgramacaoLiberacaoDocumentalItens);

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
