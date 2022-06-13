<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContainerModelosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContainerModelosTable Test Case
 */
class ContainerModelosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ContainerModelosTable
     */
    public $ContainerModelos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ContainerModelos',
        'app.TipoIsos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ContainerModelos') ? [] : ['className' => ContainerModelosTable::class];
        $this->ContainerModelos = TableRegistry::getTableLocator()->get('ContainerModelos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ContainerModelos);

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
