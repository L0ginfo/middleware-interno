<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LoteSolicitacoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LoteSolicitacoesTable Test Case
 */
class LoteSolicitacoesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.lote_solicitacoes',
        'app.lote_servicos',
        'app.tipo_servicos',
        'app.tipo_servico_status'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('LoteSolicitacoes') ? [] : ['className' => 'App\Model\Table\LoteSolicitacoesTable'];
        $this->LoteSolicitacoes = TableRegistry::get('LoteSolicitacoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LoteSolicitacoes);

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
