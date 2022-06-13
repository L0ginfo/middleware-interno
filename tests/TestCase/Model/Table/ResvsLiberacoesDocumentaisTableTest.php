<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResvsLiberacoesDocumentaisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResvsLiberacoesDocumentaisTable Test Case
 */
class ResvsLiberacoesDocumentaisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ResvsLiberacoesDocumentaisTable
     */
    public $ResvsLiberacoesDocumentais;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ResvsLiberacoesDocumentais',
        'app.Resvs',
        'app.LiberacoesDocumentais'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ResvsLiberacoesDocumentais') ? [] : ['className' => ResvsLiberacoesDocumentaisTable::class];
        $this->ResvsLiberacoesDocumentais = TableRegistry::getTableLocator()->get('ResvsLiberacoesDocumentais', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResvsLiberacoesDocumentais);

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
