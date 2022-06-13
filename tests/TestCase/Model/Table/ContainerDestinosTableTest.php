<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContainerDestinosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContainerDestinosTable Test Case
 */
class ContainerDestinosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ContainerDestinosTable
     */
    public $ContainerDestinos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ContainerDestinos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ContainerDestinos') ? [] : ['className' => ContainerDestinosTable::class];
        $this->ContainerDestinos = TableRegistry::getTableLocator()->get('ContainerDestinos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ContainerDestinos);

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
