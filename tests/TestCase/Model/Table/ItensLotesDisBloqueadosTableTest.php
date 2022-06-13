<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ItensLotesDisBloqueadosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ItensLotesDisBloqueadosTable Test Case
 */
class ItensLotesDisBloqueadosTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.itens_lotes_dis_bloqueados',
        'app.lotes_dis_bloqueados',
        'app.contratos_bloqueios',
        'app.instituicao_financeiras',
        'app.clientes',
        'app.usuario_desativacoes',
        'app.tipos_bloqueios',
        'app.tipos_unidades'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ItensLotesDisBloqueados') ? [] : ['className' => 'App\Model\Table\ItensLotesDisBloqueadosTable'];
        $this->ItensLotesDisBloqueados = TableRegistry::get('ItensLotesDisBloqueados', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ItensLotesDisBloqueados);

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
