<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResvsDocumentosTransportesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResvsDocumentosTransportesTable Test Case
 */
class ResvsDocumentosTransportesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ResvsDocumentosTransportesTable
     */
    public $ResvsDocumentosTransportes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ResvsDocumentosTransportes',
        'app.Resvs',
        'app.DocumentosTransportes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ResvsDocumentosTransportes') ? [] : ['className' => ResvsDocumentosTransportesTable::class];
        $this->ResvsDocumentosTransportes = TableRegistry::getTableLocator()->get('ResvsDocumentosTransportes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResvsDocumentosTransportes);

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
