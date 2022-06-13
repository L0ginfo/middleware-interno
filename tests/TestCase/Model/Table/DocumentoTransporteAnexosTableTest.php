<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentoTransporteAnexosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentoTransporteAnexosTable Test Case
 */
class DocumentoTransporteAnexosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentoTransporteAnexosTable
     */
    public $DocumentoTransporteAnexos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DocumentoTransporteAnexos',
        'app.Anexos',
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
        $config = TableRegistry::getTableLocator()->exists('DocumentoTransporteAnexos') ? [] : ['className' => DocumentoTransporteAnexosTable::class];
        $this->DocumentoTransporteAnexos = TableRegistry::getTableLocator()->get('DocumentoTransporteAnexos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DocumentoTransporteAnexos);

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
