<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RfbProtocolosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RfbProtocolosTable Test Case
 */
class RfbProtocolosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RfbProtocolosTable
     */
    public $RfbProtocolos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.RfbProtocolos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RfbProtocolos') ? [] : ['className' => RfbProtocolosTable::class];
        $this->RfbProtocolos = TableRegistry::getTableLocator()->get('RfbProtocolos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RfbProtocolos);

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
