<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ModeloEquipamentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ModeloEquipamentosTable Test Case
 */
class ModeloEquipamentosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ModeloEquipamentosTable
     */
    public $ModeloEquipamentos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ModeloEquipamentos',
        'app.ControleAcessoControladoras',
        'app.ControleAcessoEquipamentos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ModeloEquipamentos') ? [] : ['className' => ModeloEquipamentosTable::class];
        $this->ModeloEquipamentos = TableRegistry::getTableLocator()->get('ModeloEquipamentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ModeloEquipamentos);

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
}
