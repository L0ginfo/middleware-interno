<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdemServicoTemperaturaTiposTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdemServicoTemperaturaTiposTable Test Case
 */
class OrdemServicoTemperaturaTiposTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdemServicoTemperaturaTiposTable
     */
    public $OrdemServicoTemperaturaTipos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OrdemServicoTemperaturaTipos',
        'app.OrdemServicoTemperaturas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OrdemServicoTemperaturaTipos') ? [] : ['className' => OrdemServicoTemperaturaTiposTable::class];
        $this->OrdemServicoTemperaturaTipos = TableRegistry::getTableLocator()->get('OrdemServicoTemperaturaTipos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrdemServicoTemperaturaTipos);

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
