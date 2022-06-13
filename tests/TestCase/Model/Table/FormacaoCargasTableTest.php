<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FormacaoCargasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FormacaoCargasTable Test Case
 */
class FormacaoCargasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FormacaoCargasTable
     */
    public $FormacaoCargas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FormacaoCargas',
        'app.Transportadoras',
        'app.Veiculos',
        'app.FormacaoCargaVeiculos',
        'app.FormacaoCargaVolumeItens',
        'app.FormacaoCargaVolumes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FormacaoCargas') ? [] : ['className' => FormacaoCargasTable::class];
        $this->FormacaoCargas = TableRegistry::getTableLocator()->get('FormacaoCargas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FormacaoCargas);

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
