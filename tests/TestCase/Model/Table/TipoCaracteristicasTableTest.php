<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TipoCaracteristicasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TipoCaracteristicasTable Test Case
 */
class TipoCaracteristicasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TipoCaracteristicasTable
     */
    public $TipoCaracteristicas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TipoCaracteristicas',
        'app.Caracteristicas',
        'app.TabelaTipoCaracteristicas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TipoCaracteristicas') ? [] : ['className' => TipoCaracteristicasTable::class];
        $this->TipoCaracteristicas = TableRegistry::getTableLocator()->get('TipoCaracteristicas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TipoCaracteristicas);

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
