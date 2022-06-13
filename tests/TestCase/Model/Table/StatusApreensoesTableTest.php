<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StatusApreensoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StatusApreensoesTable Test Case
 */
class StatusApreensoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\StatusApreensoesTable
     */
    public $StatusApreensoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.StatusApreensoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('StatusApreensoes') ? [] : ['className' => StatusApreensoesTable::class];
        $this->StatusApreensoes = TableRegistry::getTableLocator()->get('StatusApreensoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StatusApreensoes);

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
