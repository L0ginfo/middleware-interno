<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FormacaoCargaVolumeItensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FormacaoCargaVolumeItensTable Test Case
 */
class FormacaoCargaVolumeItensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FormacaoCargaVolumeItensTable
     */
    public $FormacaoCargaVolumeItens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FormacaoCargaVolumeItens',
        'app.OrdemServicoItemSeparacoes',
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
        $config = TableRegistry::getTableLocator()->exists('FormacaoCargaVolumeItens') ? [] : ['className' => FormacaoCargaVolumeItensTable::class];
        $this->FormacaoCargaVolumeItens = TableRegistry::getTableLocator()->get('FormacaoCargaVolumeItens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FormacaoCargaVolumeItens);

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
