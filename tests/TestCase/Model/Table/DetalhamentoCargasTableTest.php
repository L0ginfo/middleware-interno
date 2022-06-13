<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DetalhamentoCargasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DetalhamentoCargasTable Test Case
 */
class DetalhamentoCargasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DetalhamentoCargasTable
     */
    public $DetalhamentoCargas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DetalhamentoCargas',
        'app.TabelaPrecoDetalhamentoCargas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DetalhamentoCargas') ? [] : ['className' => DetalhamentoCargasTable::class];
        $this->DetalhamentoCargas = TableRegistry::getTableLocator()->get('DetalhamentoCargas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DetalhamentoCargas);

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
