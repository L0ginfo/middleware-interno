<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContainerEntradasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContainerEntradasTable Test Case
 */
class ContainerEntradasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ContainerEntradasTable
     */
    public $ContainerEntradas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ContainerEntradas',
        'app.DocumentosTransportes',
        'app.Containers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ContainerEntradas') ? [] : ['className' => ContainerEntradasTable::class];
        $this->ContainerEntradas = TableRegistry::getTableLocator()->get('ContainerEntradas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ContainerEntradas);

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
