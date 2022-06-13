<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdemServicoItemLingadasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdemServicoItemLingadasTable Test Case
 */
class OrdemServicoItemLingadasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdemServicoItemLingadasTable
     */
    public $OrdemServicoItemLingadas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OrdemServicoItemLingadas',
        'app.OrdemServicos',
        'app.Sentidos',
        'app.Ternos',
        'app.Resvs',
        'app.PlanoCargaPoroes',
        'app.LingadaRemocoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OrdemServicoItemLingadas') ? [] : ['className' => OrdemServicoItemLingadasTable::class];
        $this->OrdemServicoItemLingadas = TableRegistry::getTableLocator()->get('OrdemServicoItemLingadas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrdemServicoItemLingadas);

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
