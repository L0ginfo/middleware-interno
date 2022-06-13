<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HistoricoSeparacaoCargasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HistoricoSeparacaoCargasTable Test Case
 */
class HistoricoSeparacaoCargasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\HistoricoSeparacaoCargasTable
     */
    public $HistoricoSeparacaoCargas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.HistoricoSeparacaoCargas',
        'app.SeparacaoCargas',
        'app.Empresas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('HistoricoSeparacaoCargas') ? [] : ['className' => HistoricoSeparacaoCargasTable::class];
        $this->HistoricoSeparacaoCargas = TableRegistry::getTableLocator()->get('HistoricoSeparacaoCargas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->HistoricoSeparacaoCargas);

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
