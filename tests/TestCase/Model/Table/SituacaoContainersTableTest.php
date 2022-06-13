<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SituacaoContainersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SituacaoContainersTable Test Case
 */
class SituacaoContainersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SituacaoContainersTable
     */
    public $SituacaoContainers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.SituacaoContainers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SituacaoContainers') ? [] : ['className' => SituacaoContainersTable::class];
        $this->SituacaoContainers = TableRegistry::getTableLocator()->get('SituacaoContainers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SituacaoContainers);

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
