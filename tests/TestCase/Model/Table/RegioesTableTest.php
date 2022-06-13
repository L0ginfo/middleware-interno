<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RegioesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RegioesTable Test Case
 */
class RegioesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RegioesTable
     */
    public $Regioes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Regioes',
        'app.Estados'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Regioes') ? [] : ['className' => RegioesTable::class];
        $this->Regioes = TableRegistry::getTableLocator()->get('Regioes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Regioes);

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
