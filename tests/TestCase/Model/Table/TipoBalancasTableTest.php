<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TipoBalancasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TipoBalancasTable Test Case
 */
class TipoBalancasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TipoBalancasTable
     */
    public $TipoBalancas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TipoBalancas',
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
        $config = TableRegistry::getTableLocator()->exists('TipoBalancas') ? [] : ['className' => TipoBalancasTable::class];
        $this->TipoBalancas = TableRegistry::getTableLocator()->get('TipoBalancas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TipoBalancas);

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
}
