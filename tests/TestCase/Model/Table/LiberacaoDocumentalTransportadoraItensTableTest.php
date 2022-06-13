<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LiberacaoDocumentalTransportadoraItensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LiberacaoDocumentalTransportadoraItensTable Test Case
 */
class LiberacaoDocumentalTransportadoraItensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LiberacaoDocumentalTransportadoraItensTable
     */
    public $LiberacaoDocumentalTransportadoraItens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.LiberacaoDocumentalTransportadoraItens',
        'app.LiberacaoDocumentalTransportadoras',
        'app.LiberacaoDocumentalItens',
        'app.Motoristas',
        'app.Veiculos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LiberacaoDocumentalTransportadoraItens') ? [] : ['className' => LiberacaoDocumentalTransportadoraItensTable::class];
        $this->LiberacaoDocumentalTransportadoraItens = TableRegistry::getTableLocator()->get('LiberacaoDocumentalTransportadoraItens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LiberacaoDocumentalTransportadoraItens);

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
