<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FaturamentoFechamentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FaturamentoFechamentosTable Test Case
 */
class FaturamentoFechamentosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FaturamentoFechamentosTable
     */
    public $FaturamentoFechamentos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FaturamentoFechamentos',
        'app.FaturamentoFechamentoItens'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FaturamentoFechamentos') ? [] : ['className' => FaturamentoFechamentosTable::class];
        $this->FaturamentoFechamentos = TableRegistry::getTableLocator()->get('FaturamentoFechamentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FaturamentoFechamentos);

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
