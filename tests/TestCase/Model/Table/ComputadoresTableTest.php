<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ComputadoresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ComputadoresTable Test Case
 */
class ComputadoresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ComputadoresTable
     */
    public $Computadores;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Computadores',
        'app.UsuarioComputadores',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Computadores') ? [] : ['className' => ComputadoresTable::class];
        $this->Computadores = TableRegistry::getTableLocator()->get('Computadores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Computadores);

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
