<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MoedasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MoedasTable Test Case
 */
class MoedasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MoedasTable
     */
    public $Moedas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Moedas',
        'app.Entradas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Moedas') ? [] : ['className' => MoedasTable::class];
        $this->Moedas = TableRegistry::getTableLocator()->get('Moedas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Moedas);

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
