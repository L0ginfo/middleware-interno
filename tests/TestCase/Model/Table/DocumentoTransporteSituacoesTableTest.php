<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentoTransporteSituacoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentoTransporteSituacoesTable Test Case
 */
class DocumentoTransporteSituacoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentoTransporteSituacoesTable
     */
    public $DocumentoTransporteSituacoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DocumentoTransporteSituacoes',
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
        $config = TableRegistry::getTableLocator()->exists('DocumentoTransporteSituacoes') ? [] : ['className' => DocumentoTransporteSituacoesTable::class];
        $this->DocumentoTransporteSituacoes = TableRegistry::getTableLocator()->get('DocumentoTransporteSituacoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DocumentoTransporteSituacoes);

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
