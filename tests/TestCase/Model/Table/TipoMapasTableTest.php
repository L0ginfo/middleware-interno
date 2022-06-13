<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TipoMapasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TipoMapasTable Test Case
 */
class TipoMapasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TipoMapasTable
     */
    public $TipoMapas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TipoMapas',
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
        $config = TableRegistry::getTableLocator()->exists('TipoMapas') ? [] : ['className' => TipoMapasTable::class];
        $this->TipoMapas = TableRegistry::getTableLocator()->get('TipoMapas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TipoMapas);

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
