<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProcedenciasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProcedenciasTable Test Case
 */
class ProcedenciasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProcedenciasTable
     */
    public $Procedencias;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Procedencias'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Procedencias') ? [] : ['className' => ProcedenciasTable::class];
        $this->Procedencias = TableRegistry::getTableLocator()->get('Procedencias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Procedencias);

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
