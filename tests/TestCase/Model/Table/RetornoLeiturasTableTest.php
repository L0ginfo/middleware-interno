<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RetornoLeiturasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RetornoLeiturasTable Test Case
 */
class RetornoLeiturasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RetornoLeiturasTable
     */
    public $RetornoLeituras;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.RetornoLeituras',
        'app.FaturamentoBaixas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RetornoLeituras') ? [] : ['className' => RetornoLeiturasTable::class];
        $this->RetornoLeituras = TableRegistry::getTableLocator()->get('RetornoLeituras', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RetornoLeituras);

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
