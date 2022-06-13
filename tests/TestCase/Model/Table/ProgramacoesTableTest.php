<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProgramacoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProgramacoesTable Test Case
 */
class ProgramacoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProgramacoesTable
     */
    public $Programacoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Programacoes',
        'app.Operacoes',
        'app.Veiculos',
        'app.Transportadoras',
        'app.Pessoas',
        'app.Modais',
        'app.Portarias',
        'app.Embalagens',
        'app.Resvs',
        'app.ProgramacaoLiberacaoDocumentais',
        'app.ProgramacaoVeiculos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Programacoes') ? [] : ['className' => ProgramacoesTable::class];
        $this->Programacoes = TableRegistry::getTableLocator()->get('Programacoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Programacoes);

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
