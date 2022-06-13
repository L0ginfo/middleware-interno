<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TiposCargasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TiposCargasTable Test Case
 */
class TiposCargasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TiposCargasTable
     */
    public $TiposCargas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TiposCargas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TiposCargas') ? [] : ['className' => TiposCargasTable::class];
        $this->TiposCargas = TableRegistry::getTableLocator()->get('TiposCargas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TiposCargas);

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
