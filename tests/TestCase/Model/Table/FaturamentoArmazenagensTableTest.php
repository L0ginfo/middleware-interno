<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FaturamentoArmazenagensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FaturamentoArmazenagensTable Test Case
 */
class FaturamentoArmazenagensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FaturamentoArmazenagensTable
     */
    public $FaturamentoArmazenagens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FaturamentoArmazenagens',
        'app.TabPrecosValidaPerArms',
        'app.Faturamentos',
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
        $config = TableRegistry::getTableLocator()->exists('FaturamentoArmazenagens') ? [] : ['className' => FaturamentoArmazenagensTable::class];
        $this->FaturamentoArmazenagens = TableRegistry::getTableLocator()->get('FaturamentoArmazenagens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FaturamentoArmazenagens);

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
