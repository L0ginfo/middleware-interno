<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OperacoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OperacoesTable Test Case
 */
class OperacoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OperacoesTable
     */
    public $Operacoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Operacoes',
        'app.Resvs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Operacoes') ? [] : ['className' => OperacoesTable::class];
        $this->Operacoes = TableRegistry::getTableLocator()->get('Operacoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Operacoes);

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
