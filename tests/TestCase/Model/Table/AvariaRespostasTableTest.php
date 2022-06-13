<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AvariaRespostasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AvariaRespostasTable Test Case
 */
class AvariaRespostasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AvariaRespostasTable
     */
    public $AvariaRespostas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.AvariaRespostas',
        'app.Avarias',
        'app.VistoriaAvariaRespostas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AvariaRespostas') ? [] : ['className' => AvariaRespostasTable::class];
        $this->AvariaRespostas = TableRegistry::getTableLocator()->get('AvariaRespostas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AvariaRespostas);

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
