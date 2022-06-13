<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LacreTiposTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LacreTiposTable Test Case
 */
class LacreTiposTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LacreTiposTable
     */
    public $LacreTipos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.LacreTipos',
        'app.Lacres',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LacreTipos') ? [] : ['className' => LacreTiposTable::class];
        $this->LacreTipos = TableRegistry::getTableLocator()->get('LacreTipos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LacreTipos);

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
