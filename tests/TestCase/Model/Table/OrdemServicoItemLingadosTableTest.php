<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdemServicoItemLingadosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdemServicoItemLingadosTable Test Case
 */
class OrdemServicoItemLingadosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdemServicoItemLingadosTable
     */
    public $OrdemServicoItemLingados;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OrdemServicoItemLingados',
        'app.OrdemServicos',
        'app.Sentidos',
        'app.Ternos',
        'app.Resvs',
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
        $config = TableRegistry::getTableLocator()->exists('OrdemServicoItemLingados') ? [] : ['className' => OrdemServicoItemLingadosTable::class];
        $this->OrdemServicoItemLingados = TableRegistry::getTableLocator()->get('OrdemServicoItemLingados', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrdemServicoItemLingados);

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
