<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TipoEstruturasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TipoEstruturasTable Test Case
 */
class TipoEstruturasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TipoEstruturasTable
     */
    public $TipoEstruturas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TipoEstruturas',
        'app.Empresas',
        'app.Areas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TipoEstruturas') ? [] : ['className' => TipoEstruturasTable::class];
        $this->TipoEstruturas = TableRegistry::getTableLocator()->get('TipoEstruturas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TipoEstruturas);

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
