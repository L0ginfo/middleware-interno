<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MapaAnexosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MapaAnexosTable Test Case
 */
class MapaAnexosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MapaAnexosTable
     */
    public $MapaAnexos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MapaAnexos',
        'app.Anexos',
        'app.Mapas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MapaAnexos') ? [] : ['className' => MapaAnexosTable::class];
        $this->MapaAnexos = TableRegistry::getTableLocator()->get('MapaAnexos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MapaAnexos);

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
