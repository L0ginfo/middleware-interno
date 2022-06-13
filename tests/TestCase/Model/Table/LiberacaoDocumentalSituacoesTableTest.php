<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LiberacaoDocumentalSituacoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LiberacaoDocumentalSituacoesTable Test Case
 */
class LiberacaoDocumentalSituacoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LiberacaoDocumentalSituacoesTable
     */
    public $LiberacaoDocumentalSituacoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.LiberacaoDocumentalSituacoes',
        'app.LiberacoesDocumentais',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LiberacaoDocumentalSituacoes') ? [] : ['className' => LiberacaoDocumentalSituacoesTable::class];
        $this->LiberacaoDocumentalSituacoes = TableRegistry::getTableLocator()->get('LiberacaoDocumentalSituacoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LiberacaoDocumentalSituacoes);

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
}
