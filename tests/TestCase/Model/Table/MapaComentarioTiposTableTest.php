<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MapaComentarioTiposTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MapaComentarioTiposTable Test Case
 */
class MapaComentarioTiposTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MapaComentarioTiposTable
     */
    public $MapaComentarioTipos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MapaComentarioTipos',
        'app.MapaComentarios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MapaComentarioTipos') ? [] : ['className' => MapaComentarioTiposTable::class];
        $this->MapaComentarioTipos = TableRegistry::getTableLocator()->get('MapaComentarioTipos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MapaComentarioTipos);

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
}
