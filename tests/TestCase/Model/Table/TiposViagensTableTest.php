<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TiposViagensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TiposViagensTable Test Case
 */
class TiposViagensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TiposViagensTable
     */
    public $TiposViagens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TiposViagens'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TiposViagens') ? [] : ['className' => TiposViagensTable::class];
        $this->TiposViagens = TableRegistry::getTableLocator()->get('TiposViagens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TiposViagens);

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
