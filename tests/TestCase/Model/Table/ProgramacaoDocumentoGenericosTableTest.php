<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProgramacaoDocumentoGenericosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProgramacaoDocumentoGenericosTable Test Case
 */
class ProgramacaoDocumentoGenericosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProgramacaoDocumentoGenericosTable
     */
    public $ProgramacaoDocumentoGenericos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ProgramacaoDocumentoGenericos',
        'app.Programacoes',
        'app.DocumentoGenericos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ProgramacaoDocumentoGenericos') ? [] : ['className' => ProgramacaoDocumentoGenericosTable::class];
        $this->ProgramacaoDocumentoGenericos = TableRegistry::getTableLocator()->get('ProgramacaoDocumentoGenericos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProgramacaoDocumentoGenericos);

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
