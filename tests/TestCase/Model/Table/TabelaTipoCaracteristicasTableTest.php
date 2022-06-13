<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TabelaTipoCaracteristicasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TabelaTipoCaracteristicasTable Test Case
 */
class TabelaTipoCaracteristicasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TabelaTipoCaracteristicasTable
     */
    public $TabelaTipoCaracteristicas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TabelaTipoCaracteristicas',
        'app.TipoCaracteristicas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TabelaTipoCaracteristicas') ? [] : ['className' => TabelaTipoCaracteristicasTable::class];
        $this->TabelaTipoCaracteristicas = TableRegistry::getTableLocator()->get('TabelaTipoCaracteristicas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TabelaTipoCaracteristicas);

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
