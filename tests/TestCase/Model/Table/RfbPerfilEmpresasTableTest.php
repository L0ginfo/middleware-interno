<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RfbPerfilEmpresasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RfbPerfilEmpresasTable Test Case
 */
class RfbPerfilEmpresasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RfbPerfilEmpresasTable
     */
    public $RfbPerfilEmpresas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.RfbPerfilEmpresas',
        'app.Empresas',
        'app.Perfis',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RfbPerfilEmpresas') ? [] : ['className' => RfbPerfilEmpresasTable::class];
        $this->RfbPerfilEmpresas = TableRegistry::getTableLocator()->get('RfbPerfilEmpresas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RfbPerfilEmpresas);

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
