<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LiberacaoDocumentalDecisaoTabelaPrecosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LiberacaoDocumentalDecisaoTabelaPrecosTable Test Case
 */
class LiberacaoDocumentalDecisaoTabelaPrecosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LiberacaoDocumentalDecisaoTabelaPrecosTable
     */
    public $LiberacaoDocumentalDecisaoTabelaPrecos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.LiberacaoDocumentalDecisaoTabelaPrecos',
        'app.LiberacaoDocumentais',
        'app.TabelaPrecos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LiberacaoDocumentalDecisaoTabelaPrecos') ? [] : ['className' => LiberacaoDocumentalDecisaoTabelaPrecosTable::class];
        $this->LiberacaoDocumentalDecisaoTabelaPrecos = TableRegistry::getTableLocator()->get('LiberacaoDocumentalDecisaoTabelaPrecos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LiberacaoDocumentalDecisaoTabelaPrecos);

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
