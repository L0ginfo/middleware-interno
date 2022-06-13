<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProgramacaoLiberacaoDocumentaisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProgramacaoLiberacaoDocumentaisTable Test Case
 */
class ProgramacaoLiberacaoDocumentaisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProgramacaoLiberacaoDocumentaisTable
     */
    public $ProgramacaoLiberacaoDocumentais;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ProgramacaoLiberacaoDocumentais',
        'app.LiberacoesDocumentais',
        'app.LiberacaoDocumentalTransportadoras',
        'app.Programacoes',
        'app.ProgramacaoLiberacaoDocumentalItens',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ProgramacaoLiberacaoDocumentais') ? [] : ['className' => ProgramacaoLiberacaoDocumentaisTable::class];
        $this->ProgramacaoLiberacaoDocumentais = TableRegistry::getTableLocator()->get('ProgramacaoLiberacaoDocumentais', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProgramacaoLiberacaoDocumentais);

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
