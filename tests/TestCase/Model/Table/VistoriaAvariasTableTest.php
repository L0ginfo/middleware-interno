<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VistoriaAvariasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VistoriaAvariasTable Test Case
 */
class VistoriaAvariasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\VistoriaAvariasTable
     */
    public $VistoriaAvarias;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.VistoriaAvarias',
        'app.Vistorias',
        'app.VistoriaItens',
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
        $config = TableRegistry::getTableLocator()->exists('VistoriaAvarias') ? [] : ['className' => VistoriaAvariasTable::class];
        $this->VistoriaAvarias = TableRegistry::getTableLocator()->get('VistoriaAvarias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->VistoriaAvarias);

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
