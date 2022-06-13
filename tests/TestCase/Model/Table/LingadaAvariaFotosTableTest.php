<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LingadaAvariaFotosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LingadaAvariaFotosTable Test Case
 */
class LingadaAvariaFotosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LingadaAvariaFotosTable
     */
    public $LingadaAvariaFotos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.LingadaAvariaFotos',
        'app.LingadaAvarias',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LingadaAvariaFotos') ? [] : ['className' => LingadaAvariaFotosTable::class];
        $this->LingadaAvariaFotos = TableRegistry::getTableLocator()->get('LingadaAvariaFotos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LingadaAvariaFotos);

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
