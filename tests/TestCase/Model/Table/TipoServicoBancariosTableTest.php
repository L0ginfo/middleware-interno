<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TipoServicoBancariosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TipoServicoBancariosTable Test Case
 */
class TipoServicoBancariosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TipoServicoBancariosTable
     */
    public $TipoServicoBancarios;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TipoServicoBancarios',
        'app.Empresas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TipoServicoBancarios') ? [] : ['className' => TipoServicoBancariosTable::class];
        $this->TipoServicoBancarios = TableRegistry::getTableLocator()->get('TipoServicoBancarios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TipoServicoBancarios);

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
