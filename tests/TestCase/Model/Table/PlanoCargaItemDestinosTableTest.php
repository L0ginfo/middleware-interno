<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlanoCargaItemDestinosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlanoCargaItemDestinosTable Test Case
 */
class PlanoCargaItemDestinosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlanoCargaItemDestinosTable
     */
    public $PlanoCargaItemDestinos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PlanoCargaItemDestinos',
        'app.PlanoCargas',
        'app.DocumentosMercadoriasItens',
        'app.Locais',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PlanoCargaItemDestinos') ? [] : ['className' => PlanoCargaItemDestinosTable::class];
        $this->PlanoCargaItemDestinos = TableRegistry::getTableLocator()->get('PlanoCargaItemDestinos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PlanoCargaItemDestinos);

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
