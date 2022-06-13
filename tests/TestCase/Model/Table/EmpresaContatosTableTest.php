<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmpresaContatosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmpresaContatosTable Test Case
 */
class EmpresaContatosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmpresaContatosTable
     */
    public $EmpresaContatos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EmpresaContatos',
        'app.Contatos',
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
        $config = TableRegistry::getTableLocator()->exists('EmpresaContatos') ? [] : ['className' => EmpresaContatosTable::class];
        $this->EmpresaContatos = TableRegistry::getTableLocator()->get('EmpresaContatos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmpresaContatos);

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
