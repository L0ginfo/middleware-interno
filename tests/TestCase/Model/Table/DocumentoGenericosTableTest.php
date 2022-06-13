<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentoGenericosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentoGenericosTable Test Case
 */
class DocumentoGenericosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentoGenericosTable
     */
    public $DocumentoGenericos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DocumentoGenericos',
        'app.DocumentoGenericoTipos',
        'app.Resvs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DocumentoGenericos') ? [] : ['className' => DocumentoGenericosTable::class];
        $this->DocumentoGenericos = TableRegistry::getTableLocator()->get('DocumentoGenericos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DocumentoGenericos);

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
