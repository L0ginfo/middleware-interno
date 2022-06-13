<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlanoCargasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlanoCargasTable Test Case
 */
class PlanoCargasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlanoCargasTable
     */
    public $PlanoCargas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PlanoCargas',
        'app.PlanejamentoMaritimos',
        'app.UnidadeMedidas',
        'app.Sentidos',
        'app.PlanoCargaTipoMercadorias',
        'app.PlanoCargaDocumentos',
        'app.PlanoCargaPoroes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PlanoCargas') ? [] : ['className' => PlanoCargasTable::class];
        $this->PlanoCargas = TableRegistry::getTableLocator()->get('PlanoCargas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PlanoCargas);

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
