<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProgramacaoResvMaritimasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProgramacaoResvMaritimasTable Test Case
 */
class ProgramacaoResvMaritimasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProgramacaoResvMaritimasTable
     */
    public $ProgramacaoResvMaritimas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ProgramacaoResvMaritimas',
        'app.Veiculos',
        'app.Programacoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ProgramacaoResvMaritimas') ? [] : ['className' => ProgramacaoResvMaritimasTable::class];
        $this->ProgramacaoResvMaritimas = TableRegistry::getTableLocator()->get('ProgramacaoResvMaritimas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProgramacaoResvMaritimas);

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
