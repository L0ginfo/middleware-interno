<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RemocoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RemocoesTable Test Case
 */
class RemocoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RemocoesTable
     */
    public $Remocoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Remocoes',
        'app.LingadaRemocoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Remocoes') ? [] : ['className' => RemocoesTable::class];
        $this->Remocoes = TableRegistry::getTableLocator()->get('Remocoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Remocoes);

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
