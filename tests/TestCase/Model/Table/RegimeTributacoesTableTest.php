<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RegimeTributacoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RegimeTributacoesTable Test Case
 */
class RegimeTributacoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RegimeTributacoesTable
     */
    public $RegimeTributacoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.RegimeTributacoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RegimeTributacoes') ? [] : ['className' => RegimeTributacoesTable::class];
        $this->RegimeTributacoes = TableRegistry::getTableLocator()->get('RegimeTributacoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RegimeTributacoes);

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
