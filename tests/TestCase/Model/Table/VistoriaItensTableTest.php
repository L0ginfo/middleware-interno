<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VistoriaItensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VistoriaItensTable Test Case
 */
class VistoriaItensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\VistoriaItensTable
     */
    public $VistoriaItens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.VistoriaItens',
        'app.Vistorias',
        'app.Containers',
        'app.Usuarios',
        'app.VistoriaAvarias',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('VistoriaItens') ? [] : ['className' => VistoriaItensTable::class];
        $this->VistoriaItens = TableRegistry::getTableLocator()->get('VistoriaItens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->VistoriaItens);

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
