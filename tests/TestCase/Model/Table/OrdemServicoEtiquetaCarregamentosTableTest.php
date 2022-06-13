<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdemServicoEtiquetaCarregamentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdemServicoEtiquetaCarregamentosTable Test Case
 */
class OrdemServicoEtiquetaCarregamentosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdemServicoEtiquetaCarregamentosTable
     */
    public $OrdemServicoEtiquetaCarregamentos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OrdemServicoEtiquetaCarregamentos',
        'app.Empresas',
        'app.EtiquetaProdutos',
        'app.OrdemServicos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OrdemServicoEtiquetaCarregamentos') ? [] : ['className' => OrdemServicoEtiquetaCarregamentosTable::class];
        $this->OrdemServicoEtiquetaCarregamentos = TableRegistry::getTableLocator()->get('OrdemServicoEtiquetaCarregamentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrdemServicoEtiquetaCarregamentos);

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
