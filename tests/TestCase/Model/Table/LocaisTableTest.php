<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocaisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocaisTable Test Case
 */
class LocaisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LocaisTable
     */
    public $Locais;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Locais',
        'app.Empresas',
        'app.Areas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Locais') ? [] : ['className' => LocaisTable::class];
        $this->Locais = TableRegistry::getTableLocator()->get('Locais', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Locais);

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
