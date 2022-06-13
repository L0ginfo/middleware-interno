<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FormacaoCargaSituacoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FormacaoCargaSituacoesTable Test Case
 */
class FormacaoCargaSituacoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FormacaoCargaSituacoesTable
     */
    public $FormacaoCargaSituacoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FormacaoCargaSituacoes',
        'app.FormacaoCargas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FormacaoCargaSituacoes') ? [] : ['className' => FormacaoCargaSituacoesTable::class];
        $this->FormacaoCargaSituacoes = TableRegistry::getTableLocator()->get('FormacaoCargaSituacoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FormacaoCargaSituacoes);

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
