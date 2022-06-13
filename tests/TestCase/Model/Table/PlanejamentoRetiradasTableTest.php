<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlanejamentoRetiradasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlanejamentoRetiradasTable Test Case
 */
class PlanejamentoRetiradasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlanejamentoRetiradasTable
     */
    public $PlanejamentoRetiradas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PlanejamentoRetiradas',
        'app.UnidadeMedidas',
        'app.Enderecos',
        'app.Produtos',
        'app.Usuarios',
        'app.StatusEstoques',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PlanejamentoRetiradas') ? [] : ['className' => PlanejamentoRetiradasTable::class];
        $this->PlanejamentoRetiradas = TableRegistry::getTableLocator()->get('PlanejamentoRetiradas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PlanejamentoRetiradas);

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
