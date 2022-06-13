<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentoTransporteLacresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentoTransporteLacresTable Test Case
 */
class DocumentoTransporteLacresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentoTransporteLacresTable
     */
    public $DocumentoTransporteLacres;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DocumentoTransporteLacres',
        'app.DocumentosTransportes',
        'app.LacreTipos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DocumentoTransporteLacres') ? [] : ['className' => DocumentoTransporteLacresTable::class];
        $this->DocumentoTransporteLacres = TableRegistry::getTableLocator()->get('DocumentoTransporteLacres', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DocumentoTransporteLacres);

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
