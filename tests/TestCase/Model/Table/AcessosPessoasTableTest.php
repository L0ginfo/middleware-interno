<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AcessosPessoasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AcessosPessoasTable Test Case
 */
class AcessosPessoasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AcessosPessoasTable
     */
    public $AcessosPessoas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.AcessosPessoas',
        'app.Pessoas',
        'app.Empresas',
        'app.Resvs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AcessosPessoas') ? [] : ['className' => AcessosPessoasTable::class];
        $this->AcessosPessoas = TableRegistry::getTableLocator()->get('AcessosPessoas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AcessosPessoas);

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
