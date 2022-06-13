<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdemServicoFotosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdemServicoFotosTable Test Case
 */
class OrdemServicoFotosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdemServicoFotosTable
     */
    public $OrdemServicoFotos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OrdemServicoFotos',
        'app.OrdemServicos',
        'app.Containers',
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
        $config = TableRegistry::getTableLocator()->exists('OrdemServicoFotos') ? [] : ['className' => OrdemServicoFotosTable::class];
        $this->OrdemServicoFotos = TableRegistry::getTableLocator()->get('OrdemServicoFotos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrdemServicoFotos);

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
