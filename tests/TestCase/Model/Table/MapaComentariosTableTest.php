<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MapaComentariosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MapaComentariosTable Test Case
 */
class MapaComentariosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MapaComentariosTable
     */
    public $MapaComentarios;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MapaComentarios',
        'app.MapaComentarioTipos',
        'app.MapaComentarioAcoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MapaComentarios') ? [] : ['className' => MapaComentariosTable::class];
        $this->MapaComentarios = TableRegistry::getTableLocator()->get('MapaComentarios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MapaComentarios);

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
