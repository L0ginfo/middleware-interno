<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmpresaRelacaoTiposTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmpresaRelacaoTiposTable Test Case
 */
class EmpresaRelacaoTiposTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmpresaRelacaoTiposTable
     */
    public $EmpresaRelacaoTipos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EmpresaRelacaoTipos',
        'app.Empresas',
        'app.TiposEmpresas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EmpresaRelacaoTipos') ? [] : ['className' => EmpresaRelacaoTiposTable::class];
        $this->EmpresaRelacaoTipos = TableRegistry::getTableLocator()->get('EmpresaRelacaoTipos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmpresaRelacaoTipos);

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
