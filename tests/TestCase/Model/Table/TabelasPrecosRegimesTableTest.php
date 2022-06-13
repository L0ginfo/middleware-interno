<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TabelasPrecosRegimesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TabelasPrecosRegimesTable Test Case
 */
class TabelasPrecosRegimesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TabelasPrecosRegimesTable
     */
    public $TabelasPrecosRegimes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TabelasPrecosRegimes',
        'app.TabelasPrecos',
        'app.RegimesAduaneiros'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TabelasPrecosRegimes') ? [] : ['className' => TabelasPrecosRegimesTable::class];
        $this->TabelasPrecosRegimes = TableRegistry::getTableLocator()->get('TabelasPrecosRegimes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TabelasPrecosRegimes);

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
