<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResvEnderecosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResvEnderecosTable Test Case
 */
class ResvEnderecosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ResvEnderecosTable
     */
    public $ResvEnderecos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ResvEnderecos',
        'app.Resvs',
        'app.Enderecos',
        'app.Usuarios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ResvEnderecos') ? [] : ['className' => ResvEnderecosTable::class];
        $this->ResvEnderecos = TableRegistry::getTableLocator()->get('ResvEnderecos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResvEnderecos);

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
