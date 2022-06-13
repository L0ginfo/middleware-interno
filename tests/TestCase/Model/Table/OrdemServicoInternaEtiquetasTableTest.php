<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdemServicoInternaEtiquetasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdemServicoInternaEtiquetasTable Test Case
 */
class OrdemServicoInternaEtiquetasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdemServicoInternaEtiquetasTable
     */
    public $OrdemServicoInternaEtiquetas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OrdemServicoInternaEtiquetas',
        'app.OrdemServicos',
        'app.UnidadeMedidas',
        'app.Enderecos',
        'app.Estoques',
        'app.Empresas',
        'app.Produtos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OrdemServicoInternaEtiquetas') ? [] : ['className' => OrdemServicoInternaEtiquetasTable::class];
        $this->OrdemServicoInternaEtiquetas = TableRegistry::getTableLocator()->get('OrdemServicoInternaEtiquetas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrdemServicoInternaEtiquetas);

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
