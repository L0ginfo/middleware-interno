<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TermoAvariasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TermoAvariasTable Test Case
 */
class TermoAvariasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TermoAvariasTable
     */
    public $TermoAvarias;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TermoAvarias',
        'app.Avarias',
        'app.OrdemServicos',
        'app.OrdemServicoItens'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TermoAvarias') ? [] : ['className' => TermoAvariasTable::class];
        $this->TermoAvarias = TableRegistry::getTableLocator()->get('TermoAvarias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TermoAvarias);

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
