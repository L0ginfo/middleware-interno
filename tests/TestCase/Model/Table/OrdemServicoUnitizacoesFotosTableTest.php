<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdemServicoUnitizacoesFotosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdemServicoUnitizacoesFotosTable Test Case
 */
class OrdemServicoUnitizacoesFotosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdemServicoUnitizacoesFotosTable
     */
    public $OrdemServicoUnitizacoesFotos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OrdemServicoUnitizacoesFotos',
        'app.Usuarios',
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
        $config = TableRegistry::getTableLocator()->exists('OrdemServicoUnitizacoesFotos') ? [] : ['className' => OrdemServicoUnitizacoesFotosTable::class];
        $this->OrdemServicoUnitizacoesFotos = TableRegistry::getTableLocator()->get('OrdemServicoUnitizacoesFotos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrdemServicoUnitizacoesFotos);

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
