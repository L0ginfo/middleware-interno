<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\IntegracaoFiscaisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\IntegracaoFiscaisTable Test Case
 */
class IntegracaoFiscaisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\IntegracaoFiscaisTable
     */
    public $IntegracaoFiscais;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.IntegracaoFiscais',
        'app.LiberacaoDocumentais',
        'app.LiberacaoDocumentalItens',
        'app.Produtos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('IntegracaoFiscais') ? [] : ['className' => IntegracaoFiscaisTable::class];
        $this->IntegracaoFiscais = TableRegistry::getTableLocator()->get('IntegracaoFiscais', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->IntegracaoFiscais);

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
