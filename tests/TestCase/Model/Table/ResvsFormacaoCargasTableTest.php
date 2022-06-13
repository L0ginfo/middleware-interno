<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResvsFormacaoCargasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResvsFormacaoCargasTable Test Case
 */
class ResvsFormacaoCargasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ResvsFormacaoCargasTable
     */
    public $ResvsFormacaoCargas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ResvsFormacaoCargas',
        'app.Resvs',
        'app.FormacaoCargas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ResvsFormacaoCargas') ? [] : ['className' => ResvsFormacaoCargasTable::class];
        $this->ResvsFormacaoCargas = TableRegistry::getTableLocator()->get('ResvsFormacaoCargas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResvsFormacaoCargas);

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
