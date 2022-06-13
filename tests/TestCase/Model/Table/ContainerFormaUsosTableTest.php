<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContainerFormaUsosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContainerFormaUsosTable Test Case
 */
class ContainerFormaUsosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ContainerFormaUsosTable
     */
    public $ContainerFormaUsos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ContainerFormaUsos',
        'app.EntradaSaidaContainers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ContainerFormaUsos') ? [] : ['className' => ContainerFormaUsosTable::class];
        $this->ContainerFormaUsos = TableRegistry::getTableLocator()->get('ContainerFormaUsos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ContainerFormaUsos);

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
