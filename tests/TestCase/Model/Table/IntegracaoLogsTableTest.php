<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\IntegracaoLogsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\IntegracaoLogsTable Test Case
 */
class IntegracaoLogsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\IntegracaoLogsTable
     */
    public $IntegracaoLogs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.IntegracaoLogs',
        'app.Integracoes',
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
        $config = TableRegistry::getTableLocator()->exists('IntegracaoLogs') ? [] : ['className' => IntegracaoLogsTable::class];
        $this->IntegracaoLogs = TableRegistry::getTableLocator()->get('IntegracaoLogs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->IntegracaoLogs);

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
