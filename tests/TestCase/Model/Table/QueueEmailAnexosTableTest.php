<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\QueueEmailAnexosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\QueueEmailAnexosTable Test Case
 */
class QueueEmailAnexosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\QueueEmailAnexosTable
     */
    public $QueueEmailAnexos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.QueueEmailAnexos',
        'app.QueueEmails',
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
        $config = TableRegistry::getTableLocator()->exists('QueueEmailAnexos') ? [] : ['className' => QueueEmailAnexosTable::class];
        $this->QueueEmailAnexos = TableRegistry::getTableLocator()->get('QueueEmailAnexos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->QueueEmailAnexos);

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
