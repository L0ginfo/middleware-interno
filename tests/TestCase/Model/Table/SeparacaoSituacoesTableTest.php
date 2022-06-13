<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SeparacaoSituacoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SeparacaoSituacoesTable Test Case
 */
class SeparacaoSituacoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SeparacaoSituacoesTable
     */
    public $SeparacaoSituacoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.SeparacaoSituacoes',
        'app.SeparacaoCargaItens',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SeparacaoSituacoes') ? [] : ['className' => SeparacaoSituacoesTable::class];
        $this->SeparacaoSituacoes = TableRegistry::getTableLocator()->get('SeparacaoSituacoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SeparacaoSituacoes);

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
