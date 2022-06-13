<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VistoriaFotosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VistoriaFotosTable Test Case
 */
class VistoriaFotosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\VistoriaFotosTable
     */
    public $VistoriaFotos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.VistoriaFotos',
        'app.Vistorias',
        'app.Usuarios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('VistoriaFotos') ? [] : ['className' => VistoriaFotosTable::class];
        $this->VistoriaFotos = TableRegistry::getTableLocator()->get('VistoriaFotos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->VistoriaFotos);

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
