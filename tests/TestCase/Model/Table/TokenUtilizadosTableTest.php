<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TokenUtilizadosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TokenUtilizadosTable Test Case
 */
class TokenUtilizadosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TokenUtilizadosTable
     */
    public $TokenUtilizados;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TokenUtilizados',
        'app.Usuarios',
        'app.Resvs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TokenUtilizados') ? [] : ['className' => TokenUtilizadosTable::class];
        $this->TokenUtilizados = TableRegistry::getTableLocator()->get('TokenUtilizados', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TokenUtilizados);

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
