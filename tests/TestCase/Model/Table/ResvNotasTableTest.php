<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResvNotasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResvNotasTable Test Case
 */
class ResvNotasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ResvNotasTable
     */
    public $ResvNotas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ResvNotas',
        'app.NotaFiscais',
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
        $config = TableRegistry::getTableLocator()->exists('ResvNotas') ? [] : ['className' => ResvNotasTable::class];
        $this->ResvNotas = TableRegistry::getTableLocator()->get('ResvNotas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResvNotas);

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
