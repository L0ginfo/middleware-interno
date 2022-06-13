<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ImportacaoEstoquesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ImportacaoEstoquesTable Test Case
 */
class ImportacaoEstoquesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ImportacaoEstoquesTable
     */
    public $ImportacaoEstoques;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ImportacaoEstoques',
        'app.Enderecos',
        'app.Produtos',
        'app.Empresas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ImportacaoEstoques') ? [] : ['className' => ImportacaoEstoquesTable::class];
        $this->ImportacaoEstoques = TableRegistry::getTableLocator()->get('ImportacaoEstoques', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ImportacaoEstoques);

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
