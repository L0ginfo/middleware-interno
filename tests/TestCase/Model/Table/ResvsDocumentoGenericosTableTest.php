<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResvsDocumentoGenericosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResvsDocumentoGenericosTable Test Case
 */
class ResvsDocumentoGenericosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ResvsDocumentoGenericosTable
     */
    public $ResvsDocumentoGenericos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ResvsDocumentoGenericos',
        'app.Resvs',
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
        $config = TableRegistry::getTableLocator()->exists('ResvsDocumentoGenericos') ? [] : ['className' => ResvsDocumentoGenericosTable::class];
        $this->ResvsDocumentoGenericos = TableRegistry::getTableLocator()->get('ResvsDocumentoGenericos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResvsDocumentoGenericos);

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
