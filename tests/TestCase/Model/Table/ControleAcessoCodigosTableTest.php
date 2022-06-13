<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ControleAcessoCodigosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ControleAcessoCodigosTable Test Case
 */
class ControleAcessoCodigosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ControleAcessoCodigosTable
     */
    public $ControleAcessoCodigos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ControleAcessoCodigos',
        'app.TipoAcessos',
        'app.CredenciamentoPessoas',
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
        $config = TableRegistry::getTableLocator()->exists('ControleAcessoCodigos') ? [] : ['className' => ControleAcessoCodigosTable::class];
        $this->ControleAcessoCodigos = TableRegistry::getTableLocator()->get('ControleAcessoCodigos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ControleAcessoCodigos);

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
