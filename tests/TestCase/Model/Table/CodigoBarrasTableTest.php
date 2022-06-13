<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CodigoBarrasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CodigoBarrasTable Test Case
 */
class CodigoBarrasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CodigoBarrasTable
     */
    public $CodigoBarras;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CodigoBarras',
        'app.CodigoBarraTipos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CodigoBarras') ? [] : ['className' => CodigoBarrasTable::class];
        $this->CodigoBarras = TableRegistry::getTableLocator()->get('CodigoBarras', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CodigoBarras);

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
