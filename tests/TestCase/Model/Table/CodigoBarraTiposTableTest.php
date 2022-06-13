<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CodigoBarraTiposTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CodigoBarraTiposTable Test Case
 */
class CodigoBarraTiposTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CodigoBarraTiposTable
     */
    public $CodigoBarraTipos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CodigoBarraTipos',
        'app.CodigoBarras',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CodigoBarraTipos') ? [] : ['className' => CodigoBarraTiposTable::class];
        $this->CodigoBarraTipos = TableRegistry::getTableLocator()->get('CodigoBarraTipos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CodigoBarraTipos);

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
