<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NcmsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NcmsTable Test Case
 */
class NcmsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\NcmsTable
     */
    public $Ncms;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Ncms',
        'app.Empresas',
        'app.Produtos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Ncms') ? [] : ['className' => NcmsTable::class];
        $this->Ncms = TableRegistry::getTableLocator()->get('Ncms', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Ncms);

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
