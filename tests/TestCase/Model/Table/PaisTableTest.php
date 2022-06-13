<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PaisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PaisTable Test Case
 */
class PaisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PaisTable
     */
    public $Pais;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Pais',
        'app.Continentes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Pais') ? [] : ['className' => PaisTable::class];
        $this->Pais = TableRegistry::getTableLocator()->get('Pais', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Pais);

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
