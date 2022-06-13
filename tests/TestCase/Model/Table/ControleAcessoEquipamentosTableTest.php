<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ControleAcessoEquipamentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ControleAcessoEquipamentosTable Test Case
 */
class ControleAcessoEquipamentosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ControleAcessoEquipamentosTable
     */
    public $ControleAcessoEquipamentos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ControleAcessoEquipamentos',
        'app.ModeloEquipamentos',
        'app.ControleAcessoSolicitacaoLeituras',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ControleAcessoEquipamentos') ? [] : ['className' => ControleAcessoEquipamentosTable::class];
        $this->ControleAcessoEquipamentos = TableRegistry::getTableLocator()->get('ControleAcessoEquipamentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ControleAcessoEquipamentos);

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
