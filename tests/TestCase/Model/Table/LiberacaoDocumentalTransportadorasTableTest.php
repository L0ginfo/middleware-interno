<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LiberacaoDocumentalTransportadorasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LiberacaoDocumentalTransportadorasTable Test Case
 */
class LiberacaoDocumentalTransportadorasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LiberacaoDocumentalTransportadorasTable
     */
    public $LiberacaoDocumentalTransportadoras;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.LiberacaoDocumentalTransportadoras',
        'app.Transportadoras',
        'app.LiberacoesDocumentais',
        'app.LiberacaoDocumentalTransportadoraItens',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LiberacaoDocumentalTransportadoras') ? [] : ['className' => LiberacaoDocumentalTransportadorasTable::class];
        $this->LiberacaoDocumentalTransportadoras = TableRegistry::getTableLocator()->get('LiberacaoDocumentalTransportadoras', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LiberacaoDocumentalTransportadoras);

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
