<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentoRegimeEspeciaisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentoRegimeEspeciaisTable Test Case
 */
class DocumentoRegimeEspeciaisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentoRegimeEspeciaisTable
     */
    public $DocumentoRegimeEspeciais;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DocumentoRegimeEspeciais',
        'app.Empresas',
        'app.TipoDocumentos',
        'app.Moedas',
        'app.Canais',
        'app.RegimesAduaneiros',
        'app.Aftns',
        'app.Pessoas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DocumentoRegimeEspeciais') ? [] : ['className' => DocumentoRegimeEspeciaisTable::class];
        $this->DocumentoRegimeEspeciais = TableRegistry::getTableLocator()->get('DocumentoRegimeEspeciais', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DocumentoRegimeEspeciais);

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
