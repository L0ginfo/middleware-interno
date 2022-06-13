<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ApreensaoItensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ApreensaoItensTable Test Case
 */
class ApreensaoItensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ApreensaoItensTable
     */
    public $ApreensaoItens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ApreensaoItens',
        'app.Ncms',
        'app.UnidadeMedidas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ApreensaoItens') ? [] : ['className' => ApreensaoItensTable::class];
        $this->ApreensaoItens = TableRegistry::getTableLocator()->get('ApreensaoItens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ApreensaoItens);

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
