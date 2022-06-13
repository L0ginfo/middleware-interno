<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MovimentacoesEstoquesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MovimentacoesEstoquesTable Test Case
 */
class MovimentacoesEstoquesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MovimentacoesEstoquesTable
     */
    public $MovimentacoesEstoques;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MovimentacoesEstoques',
        'app.Estoques',
        'app.Enderecos',
        'app.TipoMovimentacoes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MovimentacoesEstoques') ? [] : ['className' => MovimentacoesEstoquesTable::class];
        $this->MovimentacoesEstoques = TableRegistry::getTableLocator()->get('MovimentacoesEstoques', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MovimentacoesEstoques);

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
