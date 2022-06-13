<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AvariasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AvariasTable Test Case
 */
class AvariasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AvariasTable
     */
    public $Avarias;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Avarias',
        'app.TermoAvarias'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Avarias') ? [] : ['className' => AvariasTable::class];
        $this->Avarias = TableRegistry::getTableLocator()->get('Avarias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Avarias);

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
