<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProgramacaoDocumentoTransportesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProgramacaoDocumentoTransportesTable Test Case
 */
class ProgramacaoDocumentoTransportesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProgramacaoDocumentoTransportesTable
     */
    public $ProgramacaoDocumentoTransportes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ProgramacaoDocumentoTransportes',
        'app.Programacoes',
        'app.DocumentosTransportes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ProgramacaoDocumentoTransportes') ? [] : ['className' => ProgramacaoDocumentoTransportesTable::class];
        $this->ProgramacaoDocumentoTransportes = TableRegistry::getTableLocator()->get('ProgramacaoDocumentoTransportes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProgramacaoDocumentoTransportes);

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
