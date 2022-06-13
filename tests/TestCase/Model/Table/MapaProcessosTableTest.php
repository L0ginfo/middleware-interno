<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MapaProcessosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MapaProcessosTable Test Case
 */
class MapaProcessosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MapaProcessosTable
     */
    public $MapaProcessos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MapaProcessos',
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
        $config = TableRegistry::getTableLocator()->exists('MapaProcessos') ? [] : ['className' => MapaProcessosTable::class];
        $this->MapaProcessos = TableRegistry::getTableLocator()->get('MapaProcessos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MapaProcessos);

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
