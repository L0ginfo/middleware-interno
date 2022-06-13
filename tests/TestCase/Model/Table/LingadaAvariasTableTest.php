<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LingadaAvariasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LingadaAvariasTable Test Case
 */
class LingadaAvariasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LingadaAvariasTable
     */
    public $LingadaAvarias;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.LingadaAvarias',
        'app.Avarias',
        'app.OrdemServicoItemLingadas',
        'app.LingadaAvariaFotos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LingadaAvarias') ? [] : ['className' => LingadaAvariasTable::class];
        $this->LingadaAvarias = TableRegistry::getTableLocator()->get('LingadaAvarias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LingadaAvarias);

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
