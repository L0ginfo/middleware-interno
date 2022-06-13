<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ItemContainersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ItemContainersTable Test Case
 */
class ItemContainersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ItemContainersTable
     */
    public $ItemContainers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ItemContainers',
        'app.Containers',
        'app.DocumentosMercadoriasItens',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ItemContainers') ? [] : ['className' => ItemContainersTable::class];
        $this->ItemContainers = TableRegistry::getTableLocator()->get('ItemContainers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ItemContainers);

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
