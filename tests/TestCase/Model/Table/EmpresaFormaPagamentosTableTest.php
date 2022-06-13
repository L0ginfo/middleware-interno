<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmpresaFormaPagamentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmpresaFormaPagamentosTable Test Case
 */
class EmpresaFormaPagamentosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmpresaFormaPagamentosTable
     */
    public $EmpresaFormaPagamentos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EmpresaFormaPagamentos',
        'app.Empresas',
        'app.FormaPagamentos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EmpresaFormaPagamentos') ? [] : ['className' => EmpresaFormaPagamentosTable::class];
        $this->EmpresaFormaPagamentos = TableRegistry::getTableLocator()->get('EmpresaFormaPagamentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmpresaFormaPagamentos);

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
