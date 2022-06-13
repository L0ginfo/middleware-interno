<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CredenciamentoPessoaAnexosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CredenciamentoPessoaAnexosTable Test Case
 */
class CredenciamentoPessoaAnexosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CredenciamentoPessoaAnexosTable
     */
    public $CredenciamentoPessoaAnexos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CredenciamentoPessoaAnexos',
        'app.Anexos',
        'app.CredenciamentoPessoas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CredenciamentoPessoaAnexos') ? [] : ['className' => CredenciamentoPessoaAnexosTable::class];
        $this->CredenciamentoPessoaAnexos = TableRegistry::getTableLocator()->get('CredenciamentoPessoaAnexos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CredenciamentoPessoaAnexos);

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
