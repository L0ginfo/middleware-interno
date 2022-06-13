<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MapaTransacaoHistoricosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MapaTransacaoHistoricosTable Test Case
 */
class MapaTransacaoHistoricosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MapaTransacaoHistoricosTable
     */
    public $MapaTransacaoHistoricos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MapaTransacaoHistoricos',
        'app.MapaTransacaoTipos',
        'app.Mapas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MapaTransacaoHistoricos') ? [] : ['className' => MapaTransacaoHistoricosTable::class];
        $this->MapaTransacaoHistoricos = TableRegistry::getTableLocator()->get('MapaTransacaoHistoricos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MapaTransacaoHistoricos);

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
