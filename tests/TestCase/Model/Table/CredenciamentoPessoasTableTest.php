<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CredenciamentoPessoasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CredenciamentoPessoasTable Test Case
 */
class CredenciamentoPessoasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CredenciamentoPessoasTable
     */
    public $CredenciamentoPessoas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CredenciamentoPessoas',
        'app.Pessoas',
        'app.CredenciamentoPerfis',
        'app.ControleAcessoCodigos',
        'app.ControleAcessoLogs',
        'app.ControleAcessoSolicitacaoLeituras',
        'app.CredenciamentoPessoaAreas',
        'app.PessoaVeiculos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CredenciamentoPessoas') ? [] : ['className' => CredenciamentoPessoasTable::class];
        $this->CredenciamentoPessoas = TableRegistry::getTableLocator()->get('CredenciamentoPessoas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CredenciamentoPessoas);

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
