<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EntradaSaidaContainerVistoriasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EntradaSaidaContainerVistoriasTable Test Case
 */
class EntradaSaidaContainerVistoriasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EntradaSaidaContainerVistoriasTable
     */
    public $EntradaSaidaContainerVistorias;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EntradaSaidaContainerVistorias',
        'app.EntradaSaidaContainers',
        'app.Vistorias',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EntradaSaidaContainerVistorias') ? [] : ['className' => EntradaSaidaContainerVistoriasTable::class];
        $this->EntradaSaidaContainerVistorias = TableRegistry::getTableLocator()->get('EntradaSaidaContainerVistorias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EntradaSaidaContainerVistorias);

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
