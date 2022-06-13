<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmpresasRetencoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmpresasRetencoesTable Test Case
 */
class EmpresasRetencoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmpresasRetencoesTable
     */
    public $EmpresasRetencoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EmpresasRetencoes',
        'app.Empresas',
        'app.Retencoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EmpresasRetencoes') ? [] : ['className' => EmpresasRetencoesTable::class];
        $this->EmpresasRetencoes = TableRegistry::getTableLocator()->get('EmpresasRetencoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmpresasRetencoes);

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
