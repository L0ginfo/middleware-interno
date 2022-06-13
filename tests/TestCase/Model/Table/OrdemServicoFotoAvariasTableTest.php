<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdemServicoFotoAvariasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdemServicoFotoAvariasTable Test Case
 */
class OrdemServicoFotoAvariasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdemServicoFotoAvariasTable
     */
    public $OrdemServicoFotoAvarias;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OrdemServicoFotoAvarias',
        'app.OrdemServicos',
        'app.Anexos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OrdemServicoFotoAvarias') ? [] : ['className' => OrdemServicoFotoAvariasTable::class];
        $this->OrdemServicoFotoAvarias = TableRegistry::getTableLocator()->get('OrdemServicoFotoAvarias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrdemServicoFotoAvarias);

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
