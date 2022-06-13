<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TipoIsosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TipoIsosTable Test Case
 */
class TipoIsosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TipoIsosTable
     */
    public $TipoIsos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TipoIsos',
        'app.ContainerModelos',
        'app.ContainerTamanhos',
        'app.Containers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TipoIsos') ? [] : ['className' => TipoIsosTable::class];
        $this->TipoIsos = TableRegistry::getTableLocator()->get('TipoIsos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TipoIsos);

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
