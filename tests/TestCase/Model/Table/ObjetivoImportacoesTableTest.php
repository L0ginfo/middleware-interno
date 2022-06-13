<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ObjetivoImportacoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ObjetivoImportacoesTable Test Case
 */
class ObjetivoImportacoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ObjetivoImportacoesTable
     */
    public $ObjetivoImportacoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ObjetivoImportacoes',
        'app.TabelaPrecoObjetivoImportacoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ObjetivoImportacoes') ? [] : ['className' => ObjetivoImportacoesTable::class];
        $this->ObjetivoImportacoes = TableRegistry::getTableLocator()->get('ObjetivoImportacoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ObjetivoImportacoes);

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
