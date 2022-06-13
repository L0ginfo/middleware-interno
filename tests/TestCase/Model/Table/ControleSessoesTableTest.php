<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ControleSessoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ControleSessoesTable Test Case
 */
class ControleSessoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ControleSessoesTable
     */
    public $ControleSessoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ControleSessoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ControleSessoes') ? [] : ['className' => ControleSessoesTable::class];
        $this->ControleSessoes = TableRegistry::getTableLocator()->get('ControleSessoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ControleSessoes);

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
