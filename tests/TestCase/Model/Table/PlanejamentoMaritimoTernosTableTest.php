<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlanejamentoMaritimoTernosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlanejamentoMaritimoTernosTable Test Case
 */
class PlanejamentoMaritimoTernosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlanejamentoMaritimoTernosTable
     */
    public $PlanejamentoMaritimoTernos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PlanejamentoMaritimoTernos',
        'app.PlanejamentoMaritimos',
        'app.Ternos',
        'app.PlanejamentoMaritimoTernoPeriodos',
        'app.PlanejamentoMaritimoTernoUsuarios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PlanejamentoMaritimoTernos') ? [] : ['className' => PlanejamentoMaritimoTernosTable::class];
        $this->PlanejamentoMaritimoTernos = TableRegistry::getTableLocator()->get('PlanejamentoMaritimoTernos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PlanejamentoMaritimoTernos);

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
