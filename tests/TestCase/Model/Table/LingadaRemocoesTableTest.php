<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LingadaRemocoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LingadaRemocoesTable Test Case
 */
class LingadaRemocoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LingadaRemocoesTable
     */
    public $LingadaRemocoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.LingadaRemocoes',
        'app.Remocoes',
        'app.OrdemServicoItemLingadas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LingadaRemocoes') ? [] : ['className' => LingadaRemocoesTable::class];
        $this->LingadaRemocoes = TableRegistry::getTableLocator()->get('LingadaRemocoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LingadaRemocoes);

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
