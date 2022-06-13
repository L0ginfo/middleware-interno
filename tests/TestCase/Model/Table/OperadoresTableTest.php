<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OperadoresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OperadoresTable Test Case
 */
class OperadoresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OperadoresTable
     */
    public $Operadores;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Operadores'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Operadores') ? [] : ['className' => OperadoresTable::class];
        $this->Operadores = TableRegistry::getTableLocator()->get('Operadores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Operadores);

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
