<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContinentesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContinentesTable Test Case
 */
class ContinentesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ContinentesTable
     */
    public $Continentes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Continentes',
        'app.Pais'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Continentes') ? [] : ['className' => ContinentesTable::class];
        $this->Continentes = TableRegistry::getTableLocator()->get('Continentes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Continentes);

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
