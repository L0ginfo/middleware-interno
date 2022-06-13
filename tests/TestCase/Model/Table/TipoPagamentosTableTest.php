<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TipoPagamentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TipoPagamentosTable Test Case
 */
class TipoPagamentosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TipoPagamentosTable
     */
    public $TipoPagamentos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TipoPagamentos',
        'app.FormaPagamentos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TipoPagamentos') ? [] : ['className' => TipoPagamentosTable::class];
        $this->TipoPagamentos = TableRegistry::getTableLocator()->get('TipoPagamentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TipoPagamentos);

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
