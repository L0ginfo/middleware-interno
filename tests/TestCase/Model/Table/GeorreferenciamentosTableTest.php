<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GeorreferenciamentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GeorreferenciamentosTable Test Case
 */
class GeorreferenciamentosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GeorreferenciamentosTable
     */
    public $Georreferenciamentos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Georreferenciamentos',
        'app.GeorreferenciamentoTipos',
        'app.Areas',
        'app.Balancas',
        'app.Cameras',
        'app.ControleAcessoControladoras',
        'app.Empresas',
        'app.Locais',
        'app.Portarias',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Georreferenciamentos') ? [] : ['className' => GeorreferenciamentosTable::class];
        $this->Georreferenciamentos = TableRegistry::getTableLocator()->get('Georreferenciamentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Georreferenciamentos);

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
