<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TipoCodigoEmpresasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TipoCodigoEmpresasTable Test Case
 */
class TipoCodigoEmpresasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TipoCodigoEmpresasTable
     */
    public $TipoCodigoEmpresas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TipoCodigoEmpresas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TipoCodigoEmpresas') ? [] : ['className' => TipoCodigoEmpresasTable::class];
        $this->TipoCodigoEmpresas = TableRegistry::getTableLocator()->get('TipoCodigoEmpresas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TipoCodigoEmpresas);

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
