<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ParametroConsultasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ParametroConsultasTable Test Case
 */
class ParametroConsultasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ParametroConsultasTable
     */
    public $ParametroConsultas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ParametroConsultas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ParametroConsultas') ? [] : ['className' => ParametroConsultasTable::class];
        $this->ParametroConsultas = TableRegistry::getTableLocator()->get('ParametroConsultas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ParametroConsultas);

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
