<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SeparacaoCargasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SeparacaoCargasTable Test Case
 */
class SeparacaoCargasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SeparacaoCargasTable
     */
    public $SeparacaoCargas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.SeparacaoCargas',
        'app.Empresas',
        'app.SeparacaoSituacoes',
        'app.SeparacaoCargaItens',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SeparacaoCargas') ? [] : ['className' => SeparacaoCargasTable::class];
        $this->SeparacaoCargas = TableRegistry::getTableLocator()->get('SeparacaoCargas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SeparacaoCargas);

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
