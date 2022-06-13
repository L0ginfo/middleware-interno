<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlanoCargaPoroesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlanoCargaPoroesTable Test Case
 */
class PlanoCargaPoroesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlanoCargaPoroesTable
     */
    public $PlanoCargaPoroes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PlanoCargaPoroes',
        'app.PlanoCargas',
        'app.Poroes',
        'app.DocumentosMercadoriasItens',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PlanoCargaPoroes') ? [] : ['className' => PlanoCargaPoroesTable::class];
        $this->PlanoCargaPoroes = TableRegistry::getTableLocator()->get('PlanoCargaPoroes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PlanoCargaPoroes);

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
