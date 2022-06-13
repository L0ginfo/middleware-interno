<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NaturezasCargasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NaturezasCargasTable Test Case
 */
class NaturezasCargasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\NaturezasCargasTable
     */
    public $NaturezasCargas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.NaturezasCargas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('NaturezasCargas') ? [] : ['className' => NaturezasCargasTable::class];
        $this->NaturezasCargas = TableRegistry::getTableLocator()->get('NaturezasCargas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NaturezasCargas);

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
