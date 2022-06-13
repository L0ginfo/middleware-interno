<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VistoriaAvariaRespostasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VistoriaAvariaRespostasTable Test Case
 */
class VistoriaAvariaRespostasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\VistoriaAvariaRespostasTable
     */
    public $VistoriaAvariaRespostas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.VistoriaAvariaRespostas',
        'app.Avarias',
        'app.AvariaRespostas',
        'app.VistoriaAvarias',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('VistoriaAvariaRespostas') ? [] : ['className' => VistoriaAvariaRespostasTable::class];
        $this->VistoriaAvariaRespostas = TableRegistry::getTableLocator()->get('VistoriaAvariaRespostas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->VistoriaAvariaRespostas);

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
