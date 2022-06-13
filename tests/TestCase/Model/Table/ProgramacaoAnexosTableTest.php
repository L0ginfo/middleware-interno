<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProgramacaoAnexosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProgramacaoAnexosTable Test Case
 */
class ProgramacaoAnexosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProgramacaoAnexosTable
     */
    public $ProgramacaoAnexos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ProgramacaoAnexos',
        'app.Programacoes',
        'app.Anexos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ProgramacaoAnexos') ? [] : ['className' => ProgramacaoAnexosTable::class];
        $this->ProgramacaoAnexos = TableRegistry::getTableLocator()->get('ProgramacaoAnexos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProgramacaoAnexos);

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
