<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StatusEstoquesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StatusEstoquesTable Test Case
 */
class StatusEstoquesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\StatusEstoquesTable
     */
    public $StatusEstoques;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.StatusEstoques',
        'app.EstoqueEnderecos',
        'app.MovimentacoesEstoques',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('StatusEstoques') ? [] : ['className' => StatusEstoquesTable::class];
        $this->StatusEstoques = TableRegistry::getTableLocator()->get('StatusEstoques', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StatusEstoques);

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
