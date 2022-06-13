<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResvPlanejamentoMaritimosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResvPlanejamentoMaritimosTable Test Case
 */
class ResvPlanejamentoMaritimosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ResvPlanejamentoMaritimosTable
     */
    public $ResvPlanejamentoMaritimos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ResvPlanejamentoMaritimos',
        'app.Resvs',
        'app.PlanejamentoMaritimos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ResvPlanejamentoMaritimos') ? [] : ['className' => ResvPlanejamentoMaritimosTable::class];
        $this->ResvPlanejamentoMaritimos = TableRegistry::getTableLocator()->get('ResvPlanejamentoMaritimos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResvPlanejamentoMaritimos);

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
