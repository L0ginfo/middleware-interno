<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MapasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MapasTable Test Case
 */
class MapasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MapasTable
     */
    public $Mapas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Mapas',
        'app.Empresas',
        'app.DocumentosTransportes',
        'app.TipoMapas',
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
        $config = TableRegistry::getTableLocator()->exists('Mapas') ? [] : ['className' => MapasTable::class];
        $this->Mapas = TableRegistry::getTableLocator()->get('Mapas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Mapas);

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
