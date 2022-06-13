<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentoRegimeEspecialTributosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentoRegimeEspecialTributosTable Test Case
 */
class DocumentoRegimeEspecialTributosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentoRegimeEspecialTributosTable
     */
    public $DocumentoRegimeEspecialTributos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DocumentoRegimeEspecialTributos',
        'app.Tributos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DocumentoRegimeEspecialTributos') ? [] : ['className' => DocumentoRegimeEspecialTributosTable::class];
        $this->DocumentoRegimeEspecialTributos = TableRegistry::getTableLocator()->get('DocumentoRegimeEspecialTributos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DocumentoRegimeEspecialTributos);

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
