<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GeorreferenciamentoTiposTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GeorreferenciamentoTiposTable Test Case
 */
class GeorreferenciamentoTiposTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GeorreferenciamentoTiposTable
     */
    public $GeorreferenciamentoTipos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.GeorreferenciamentoTipos',
        'app.Georreferenciamentos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('GeorreferenciamentoTipos') ? [] : ['className' => GeorreferenciamentoTiposTable::class];
        $this->GeorreferenciamentoTipos = TableRegistry::getTableLocator()->get('GeorreferenciamentoTipos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->GeorreferenciamentoTipos);

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
