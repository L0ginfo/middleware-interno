<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlanejamentoMaritimoTernoUsuariosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlanejamentoMaritimoTernoUsuariosTable Test Case
 */
class PlanejamentoMaritimoTernoUsuariosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlanejamentoMaritimoTernoUsuariosTable
     */
    public $PlanejamentoMaritimoTernoUsuarios;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PlanejamentoMaritimoTernoUsuarios',
        'app.PlanejamentoMaritimoTernos',
        'app.Usuarios',
        'app.PortoTrabalhoFuncoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PlanejamentoMaritimoTernoUsuarios') ? [] : ['className' => PlanejamentoMaritimoTernoUsuariosTable::class];
        $this->PlanejamentoMaritimoTernoUsuarios = TableRegistry::getTableLocator()->get('PlanejamentoMaritimoTernoUsuarios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PlanejamentoMaritimoTernoUsuarios);

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
