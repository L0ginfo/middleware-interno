<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailAnexosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailAnexosTable Test Case
 */
class EmailAnexosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailAnexosTable
     */
    public $EmailAnexos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EmailAnexos',
        'app.Emails',
        'app.Anexos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EmailAnexos') ? [] : ['className' => EmailAnexosTable::class];
        $this->EmailAnexos = TableRegistry::getTableLocator()->get('EmailAnexos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmailAnexos);

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
