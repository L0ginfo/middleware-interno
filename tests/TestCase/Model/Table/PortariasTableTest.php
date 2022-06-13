<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PortariasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PortariasTable Test Case
 */
class PortariasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PortariasTable
     */
    public $Portarias;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Portarias',
        'app.Modais',
        'app.Empresas',
        'app.Resvs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Portarias') ? [] : ['className' => PortariasTable::class];
        $this->Portarias = TableRegistry::getTableLocator()->get('Portarias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Portarias);

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
