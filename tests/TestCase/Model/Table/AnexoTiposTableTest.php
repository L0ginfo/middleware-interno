<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AnexoTiposTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AnexoTiposTable Test Case
 */
class AnexoTiposTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AnexoTiposTable
     */
    public $AnexoTipos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.AnexoTipos',
        'app.AnexoTipoGrupos',
        'app.AnexoTabelas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AnexoTipos') ? [] : ['className' => AnexoTiposTable::class];
        $this->AnexoTipos = TableRegistry::getTableLocator()->get('AnexoTipos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AnexoTipos);

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
