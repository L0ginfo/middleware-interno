<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TipoLogradourosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TipoLogradourosTable Test Case
 */
class TipoLogradourosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TipoLogradourosTable
     */
    public $TipoLogradouros;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TipoLogradouros',
        'app.Logradouros'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TipoLogradouros') ? [] : ['className' => TipoLogradourosTable::class];
        $this->TipoLogradouros = TableRegistry::getTableLocator()->get('TipoLogradouros', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TipoLogradouros);

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
