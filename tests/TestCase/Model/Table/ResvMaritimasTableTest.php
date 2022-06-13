<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResvMaritimasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResvMaritimasTable Test Case
 */
class ResvMaritimasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ResvMaritimasTable
     */
    public $ResvMaritimas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ResvMaritimas',
        'app.Veiculos',
        'app.Resvs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ResvMaritimas') ? [] : ['className' => ResvMaritimasTable::class];
        $this->ResvMaritimas = TableRegistry::getTableLocator()->get('ResvMaritimas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResvMaritimas);

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
