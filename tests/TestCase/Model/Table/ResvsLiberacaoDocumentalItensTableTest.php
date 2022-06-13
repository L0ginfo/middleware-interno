<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResvsLiberacaoDocumentalItensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResvsLiberacaoDocumentalItensTable Test Case
 */
class ResvsLiberacaoDocumentalItensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ResvsLiberacaoDocumentalItensTable
     */
    public $ResvsLiberacaoDocumentalItens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ResvsLiberacaoDocumentalItens',
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
        $config = TableRegistry::getTableLocator()->exists('ResvsLiberacaoDocumentalItens') ? [] : ['className' => ResvsLiberacaoDocumentalItensTable::class];
        $this->ResvsLiberacaoDocumentalItens = TableRegistry::getTableLocator()->get('ResvsLiberacaoDocumentalItens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResvsLiberacaoDocumentalItens);

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
