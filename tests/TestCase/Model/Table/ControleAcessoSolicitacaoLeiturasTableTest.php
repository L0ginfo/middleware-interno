<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ControleAcessoSolicitacaoLeiturasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ControleAcessoSolicitacaoLeiturasTable Test Case
 */
class ControleAcessoSolicitacaoLeiturasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ControleAcessoSolicitacaoLeiturasTable
     */
    public $ControleAcessoSolicitacaoLeituras;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ControleAcessoSolicitacaoLeituras',
        'app.ControleAcessoControladoras',
        'app.CredenciamentoPessoas',
        'app.ControleAcessoEquipamentos',
        'app.ControleAcessoCodigos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ControleAcessoSolicitacaoLeituras') ? [] : ['className' => ControleAcessoSolicitacaoLeiturasTable::class];
        $this->ControleAcessoSolicitacaoLeituras = TableRegistry::getTableLocator()->get('ControleAcessoSolicitacaoLeituras', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ControleAcessoSolicitacaoLeituras);

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
