<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContratosBloqueiosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContratosBloqueiosTable Test Case
 */
class ContratosBloqueiosTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.contratos_bloqueios',
        'app.instituicao_financeiras',
        'app.clientes',
        'app.usuario_desativacoes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ContratosBloqueios') ? [] : ['className' => 'App\Model\Table\ContratosBloqueiosTable'];
        $this->ContratosBloqueios = TableRegistry::get('ContratosBloqueios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ContratosBloqueios);

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
