<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TiposFaturamentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TiposFaturamentosTable Test Case
 */
class TiposFaturamentosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TiposFaturamentosTable
     */
    public $TiposFaturamentos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TiposFaturamentos',
        'app.TabelasPrecos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TiposFaturamentos') ? [] : ['className' => TiposFaturamentosTable::class];
        $this->TiposFaturamentos = TableRegistry::getTableLocator()->get('TiposFaturamentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TiposFaturamentos);

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
