<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SeparacaoCargaItensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SeparacaoCargaItensTable Test Case
 */
class SeparacaoCargaItensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SeparacaoCargaItensTable
     */
    public $SeparacaoCargaItens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.SeparacaoCargaItens',
        'app.Produtos',
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
        $config = TableRegistry::getTableLocator()->exists('SeparacaoCargaItens') ? [] : ['className' => SeparacaoCargaItensTable::class];
        $this->SeparacaoCargaItens = TableRegistry::getTableLocator()->get('SeparacaoCargaItens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SeparacaoCargaItens);

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
