<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdemServicoCarregamentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdemServicoCarregamentosTable Test Case
 */
class OrdemServicoCarregamentosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdemServicoCarregamentosTable
     */
    public $OrdemServicoCarregamentos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OrdemServicoCarregamentos',
        'app.Empresas',
        'app.Estoques',
        'app.OrdemServicos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OrdemServicoCarregamentos') ? [] : ['className' => OrdemServicoCarregamentosTable::class];
        $this->OrdemServicoCarregamentos = TableRegistry::getTableLocator()->get('OrdemServicoCarregamentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrdemServicoCarregamentos);

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
