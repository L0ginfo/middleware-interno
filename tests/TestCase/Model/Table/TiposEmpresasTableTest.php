<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TiposEmpresasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TiposEmpresasTable Test Case
 */
class TiposEmpresasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TiposEmpresasTable
     */
    public $TiposEmpresas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TiposEmpresas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TiposEmpresas') ? [] : ['className' => TiposEmpresasTable::class];
        $this->TiposEmpresas = TableRegistry::getTableLocator()->get('TiposEmpresas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TiposEmpresas);

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
