<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LiberacoesDocumentaisItensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LiberacoesDocumentaisItensTable Test Case
 */
class LiberacoesDocumentaisItensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LiberacoesDocumentaisItensTable
     */
    public $LiberacoesDocumentaisItens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.LiberacoesDocumentaisItens',
        'app.LiberacoesDocumentais',
        'app.RegimesAduaneiros',
        'app.Estoques',
        'app.TabelasPrecos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LiberacoesDocumentaisItens') ? [] : ['className' => LiberacoesDocumentaisItensTable::class];
        $this->LiberacoesDocumentaisItens = TableRegistry::getTableLocator()->get('LiberacoesDocumentaisItens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LiberacoesDocumentaisItens);

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
