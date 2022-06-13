<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SolicitacaoLeituraOcrsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SolicitacaoLeituraOcrsTable Test Case
 */
class SolicitacaoLeituraOcrsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SolicitacaoLeituraOcrsTable
     */
    public $SolicitacaoLeituraOcrs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.SolicitacaoLeituraOcrs',
        'app.Balancas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SolicitacaoLeituraOcrs') ? [] : ['className' => SolicitacaoLeituraOcrsTable::class];
        $this->SolicitacaoLeituraOcrs = TableRegistry::getTableLocator()->get('SolicitacaoLeituraOcrs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SolicitacaoLeituraOcrs);

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
