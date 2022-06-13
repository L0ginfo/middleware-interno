<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LiberadoClientefinaisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LiberadoClientefinaisTable Test Case
 */
class LiberadoClientefinaisTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.liberado_clientefinais'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('LiberadoClientefinais') ? [] : ['className' => 'App\Model\Table\LiberadoClientefinaisTable'];
        $this->LiberadoClientefinais = TableRegistry::get('LiberadoClientefinais', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LiberadoClientefinais);

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
