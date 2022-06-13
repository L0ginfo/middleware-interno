<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProgramacaoContainerLacresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProgramacaoContainerLacresTable Test Case
 */
class ProgramacaoContainerLacresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProgramacaoContainerLacresTable
     */
    public $ProgramacaoContainerLacres;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ProgramacaoContainerLacres',
        'app.LacreTipos',
        'app.ProgramacaoContainers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ProgramacaoContainerLacres') ? [] : ['className' => ProgramacaoContainerLacresTable::class];
        $this->ProgramacaoContainerLacres = TableRegistry::getTableLocator()->get('ProgramacaoContainerLacres', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProgramacaoContainerLacres);

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
