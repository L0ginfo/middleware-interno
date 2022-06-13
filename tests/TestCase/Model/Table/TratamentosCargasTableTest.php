<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TratamentosCargasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TratamentosCargasTable Test Case
 */
class TratamentosCargasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TratamentosCargasTable
     */
    public $TratamentosCargas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::getTableLocator()->exists('TratamentosCargas') ? [] : ['className' => TratamentosCargasTable::class];
        $this->TratamentosCargas = TableRegistry::getTableLocator()->get('TratamentosCargas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TratamentosCargas);

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
