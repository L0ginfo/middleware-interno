<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FaturamentoBaixasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FaturamentoBaixasTable Test Case
 */
class FaturamentoBaixasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FaturamentoBaixasTable
     */
    public $FaturamentoBaixas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FaturamentoBaixas',
        'app.TipoPagamentos',
        'app.Bancos',
        'app.FaturamentoArmazenagens'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FaturamentoBaixas') ? [] : ['className' => FaturamentoBaixasTable::class];
        $this->FaturamentoBaixas = TableRegistry::getTableLocator()->get('FaturamentoBaixas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FaturamentoBaixas);

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
