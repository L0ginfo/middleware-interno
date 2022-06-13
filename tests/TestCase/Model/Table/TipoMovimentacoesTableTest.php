<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TipoMovimentacoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TipoMovimentacoesTable Test Case
 */
class TipoMovimentacoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TipoMovimentacoesTable
     */
    public $TipoMovimentacoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TipoMovimentacoes',
        'app.MovimentacoesEstoques'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TipoMovimentacoes') ? [] : ['className' => TipoMovimentacoesTable::class];
        $this->TipoMovimentacoes = TableRegistry::getTableLocator()->get('TipoMovimentacoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TipoMovimentacoes);

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
