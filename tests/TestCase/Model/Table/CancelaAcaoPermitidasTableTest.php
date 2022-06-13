<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CancelaAcaoPermitidasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CancelaAcaoPermitidasTable Test Case
 */
class CancelaAcaoPermitidasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CancelaAcaoPermitidasTable
     */
    public $CancelaAcaoPermitidas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CancelaAcaoPermitidas',
        'app.Cancelas',
        'app.CancelaAcoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CancelaAcaoPermitidas') ? [] : ['className' => CancelaAcaoPermitidasTable::class];
        $this->CancelaAcaoPermitidas = TableRegistry::getTableLocator()->get('CancelaAcaoPermitidas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CancelaAcaoPermitidas);

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
