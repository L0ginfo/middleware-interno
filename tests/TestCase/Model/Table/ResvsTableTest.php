<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResvsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResvsTable Test Case
 */
class ResvsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ResvsTable
     */
    public $Resvs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Resvs',
        'app.Operacoes',
        'app.Veiculos',
        'app.Transportadoras',
        'app.Pessoas',
        'app.Modais',
        'app.Portarias',
        'app.Empresas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Resvs') ? [] : ['className' => ResvsTable::class];
        $this->Resvs = TableRegistry::getTableLocator()->get('Resvs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Resvs);

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
