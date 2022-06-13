<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AnexoTabelasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AnexoTabelasTable Test Case
 */
class AnexoTabelasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AnexoTabelasTable
     */
    public $AnexoTabelas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.AnexoTabelas',
        'app.Anexos',
        'app.AnexoTipos',
        'app.AnexoSituacoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AnexoTabelas') ? [] : ['className' => AnexoTabelasTable::class];
        $this->AnexoTabelas = TableRegistry::getTableLocator()->get('AnexoTabelas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AnexoTabelas);

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
