<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MapaAnexoTiposTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MapaAnexoTiposTable Test Case
 */
class MapaAnexoTiposTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MapaAnexoTiposTable
     */
    public $MapaAnexoTipos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MapaAnexoTipos',
        'app.MapaAnexos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MapaAnexoTipos') ? [] : ['className' => MapaAnexoTiposTable::class];
        $this->MapaAnexoTipos = TableRegistry::getTableLocator()->get('MapaAnexoTipos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MapaAnexoTipos);

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
