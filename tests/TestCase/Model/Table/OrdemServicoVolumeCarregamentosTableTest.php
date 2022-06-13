<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdemServicoVolumeCarregamentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdemServicoVolumeCarregamentosTable Test Case
 */
class OrdemServicoVolumeCarregamentosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdemServicoVolumeCarregamentosTable
     */
    public $OrdemServicoVolumeCarregamentos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OrdemServicoVolumeCarregamentos',
        'app.Empresas',
        'app.FormacaoCargaVolumes',
        'app.OrdemServicos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OrdemServicoVolumeCarregamentos') ? [] : ['className' => OrdemServicoVolumeCarregamentosTable::class];
        $this->OrdemServicoVolumeCarregamentos = TableRegistry::getTableLocator()->get('OrdemServicoVolumeCarregamentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrdemServicoVolumeCarregamentos);

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
