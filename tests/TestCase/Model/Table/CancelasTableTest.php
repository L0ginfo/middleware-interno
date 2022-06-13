<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CancelasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CancelasTable Test Case
 */
class CancelasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CancelasTable
     */
    public $Cancelas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Cancelas',
        'app.Balancas',
        'app.CancelaAcaoPermitidas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Cancelas') ? [] : ['className' => CancelasTable::class];
        $this->Cancelas = TableRegistry::getTableLocator()->get('Cancelas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cancelas);

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
