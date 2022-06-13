<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StatusIntegracoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StatusIntegracoesTable Test Case
 */
class StatusIntegracoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\StatusIntegracoesTable
     */
    public $StatusIntegracoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.StatusIntegracoes',
        'app.FaturamentoBaixas',
        'app.FilaIntegracaoFaturamentoBaixas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('StatusIntegracoes') ? [] : ['className' => StatusIntegracoesTable::class];
        $this->StatusIntegracoes = TableRegistry::getTableLocator()->get('StatusIntegracoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StatusIntegracoes);

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
