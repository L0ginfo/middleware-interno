<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PortoTrabalhoFuncoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PortoTrabalhoFuncoesTable Test Case
 */
class PortoTrabalhoFuncoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PortoTrabalhoFuncoesTable
     */
    public $PortoTrabalhoFuncoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PortoTrabalhoFuncoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PortoTrabalhoFuncoes') ? [] : ['className' => PortoTrabalhoFuncoesTable::class];
        $this->PortoTrabalhoFuncoes = TableRegistry::getTableLocator()->get('PortoTrabalhoFuncoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PortoTrabalhoFuncoes);

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
