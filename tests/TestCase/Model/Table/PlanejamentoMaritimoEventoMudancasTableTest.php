<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlanejamentoMaritimoEventoMudancasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlanejamentoMaritimoEventoMudancasTable Test Case
 */
class PlanejamentoMaritimoEventoMudancasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlanejamentoMaritimoEventoMudancasTable
     */
    public $PlanejamentoMaritimoEventoMudancas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PlanejamentoMaritimoEventoMudancas',
        'app.Eventos',
        'app.PlanejamentoMaritimos',
        'app.PlanejamentoMaritimoMudancas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PlanejamentoMaritimoEventoMudancas') ? [] : ['className' => PlanejamentoMaritimoEventoMudancasTable::class];
        $this->PlanejamentoMaritimoEventoMudancas = TableRegistry::getTableLocator()->get('PlanejamentoMaritimoEventoMudancas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PlanejamentoMaritimoEventoMudancas);

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
