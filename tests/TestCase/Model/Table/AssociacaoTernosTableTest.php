<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AssociacaoTernosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AssociacaoTernosTable Test Case
 */
class AssociacaoTernosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AssociacaoTernosTable
     */
    public $AssociacaoTernos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.AssociacaoTernos',
        'app.OrdemServicos',
        'app.Poroes',
        'app.Ternos',
        'app.Sentidos',
        'app.PlanoCargas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AssociacaoTernos') ? [] : ['className' => AssociacaoTernosTable::class];
        $this->AssociacaoTernos = TableRegistry::getTableLocator()->get('AssociacaoTernos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AssociacaoTernos);

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
