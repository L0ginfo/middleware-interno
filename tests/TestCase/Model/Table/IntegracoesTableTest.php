<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\IntegracoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\IntegracoesTable Test Case
 */
class IntegracoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\IntegracoesTable
     */
    public $Integracoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Integracoes',
        'app.IntegracaoLogs',
        'app.IntegracaoTraducoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Integracoes') ? [] : ['className' => IntegracoesTable::class];
        $this->Integracoes = TableRegistry::getTableLocator()->get('Integracoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Integracoes);

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

    /**
     * Test beforeSave method
     *
     * @return void
     */
    public function testBeforeSave()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
