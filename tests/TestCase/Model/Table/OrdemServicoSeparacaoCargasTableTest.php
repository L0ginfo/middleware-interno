<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdemServicoSeparacaoCargasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdemServicoSeparacaoCargasTable Test Case
 */
class OrdemServicoSeparacaoCargasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdemServicoSeparacaoCargasTable
     */
    public $OrdemServicoSeparacaoCargas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OrdemServicoSeparacaoCargas',
        'app.OrdemServicos',
        'app.SeparacaoCargas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OrdemServicoSeparacaoCargas') ? [] : ['className' => OrdemServicoSeparacaoCargasTable::class];
        $this->OrdemServicoSeparacaoCargas = TableRegistry::getTableLocator()->get('OrdemServicoSeparacaoCargas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrdemServicoSeparacaoCargas);

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
