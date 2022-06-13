<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TabelasPrecosTratamentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TabelasPrecosTratamentosTable Test Case
 */
class TabelasPrecosTratamentosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TabelasPrecosTratamentosTable
     */
    public $TabelasPrecosTratamentos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TabelasPrecosTratamentos',
        'app.TabelasPrecos',
        'app.TratamentosCargas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TabelasPrecosTratamentos') ? [] : ['className' => TabelasPrecosTratamentosTable::class];
        $this->TabelasPrecosTratamentos = TableRegistry::getTableLocator()->get('TabelasPrecosTratamentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TabelasPrecosTratamentos);

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
