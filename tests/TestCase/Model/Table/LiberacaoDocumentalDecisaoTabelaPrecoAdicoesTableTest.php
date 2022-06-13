<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LiberacaoDocumentalDecisaoTabelaPrecoAdicoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LiberacaoDocumentalDecisaoTabelaPrecoAdicoesTable Test Case
 */
class LiberacaoDocumentalDecisaoTabelaPrecoAdicoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LiberacaoDocumentalDecisaoTabelaPrecoAdicoesTable
     */
    public $LiberacaoDocumentalDecisaoTabelaPrecoAdicoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.LiberacaoDocumentalDecisaoTabelaPrecoAdicoes',
        'app.RegimesAduaneiros',
        'app.Incoterms',
        'app.Moedas',
        'app.Ncms',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LiberacaoDocumentalDecisaoTabelaPrecoAdicoes') ? [] : ['className' => LiberacaoDocumentalDecisaoTabelaPrecoAdicoesTable::class];
        $this->LiberacaoDocumentalDecisaoTabelaPrecoAdicoes = TableRegistry::getTableLocator()->get('LiberacaoDocumentalDecisaoTabelaPrecoAdicoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LiberacaoDocumentalDecisaoTabelaPrecoAdicoes);

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
