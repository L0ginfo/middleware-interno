<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TiposValoresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TiposValoresTable Test Case
 */
class TiposValoresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TiposValoresTable
     */
    public $TiposValores;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TiposValores'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TiposValores') ? [] : ['className' => TiposValoresTable::class];
        $this->TiposValores = TableRegistry::getTableLocator()->get('TiposValores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TiposValores);

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
