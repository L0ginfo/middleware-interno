<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlanejamentoMaritimoAnexosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlanejamentoMaritimoAnexosTable Test Case
 */
class PlanejamentoMaritimoAnexosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlanejamentoMaritimoAnexosTable
     */
    public $PlanejamentoMaritimoAnexos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PlanejamentoMaritimoAnexos',
        'app.PlanejamentoMaritimos',
        'app.Axenos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PlanejamentoMaritimoAnexos') ? [] : ['className' => PlanejamentoMaritimoAnexosTable::class];
        $this->PlanejamentoMaritimoAnexos = TableRegistry::getTableLocator()->get('PlanejamentoMaritimoAnexos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PlanejamentoMaritimoAnexos);

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
