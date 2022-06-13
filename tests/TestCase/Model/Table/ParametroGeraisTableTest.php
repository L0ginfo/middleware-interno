<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ParametroGeraisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ParametroGeraisTable Test Case
 */
class ParametroGeraisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ParametroGeraisTable
     */
    public $ParametroGerais;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ParametroGerais'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ParametroGerais') ? [] : ['className' => ParametroGeraisTable::class];
        $this->ParametroGerais = TableRegistry::getTableLocator()->get('ParametroGerais', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ParametroGerais);

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
