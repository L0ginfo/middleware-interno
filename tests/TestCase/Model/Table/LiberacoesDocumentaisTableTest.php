<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LiberacoesDocumentaisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LiberacoesDocumentaisTable Test Case
 */
class LiberacoesDocumentaisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LiberacoesDocumentaisTable
     */
    public $LiberacoesDocumentais;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.LiberacoesDocumentais',
        'app.Empresas',
        'app.TipoDocumentos',
        'app.Moedas',
        'app.Canais',
        'app.RegimesAduaneiros',
        'app.Aftns'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LiberacoesDocumentais') ? [] : ['className' => LiberacoesDocumentaisTable::class];
        $this->LiberacoesDocumentais = TableRegistry::getTableLocator()->get('LiberacoesDocumentais', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LiberacoesDocumentais);

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
