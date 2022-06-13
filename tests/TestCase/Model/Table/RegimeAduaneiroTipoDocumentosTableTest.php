<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RegimeAduaneiroTipoDocumentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RegimeAduaneiroTipoDocumentosTable Test Case
 */
class RegimeAduaneiroTipoDocumentosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RegimeAduaneiroTipoDocumentosTable
     */
    public $RegimeAduaneiroTipoDocumentos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.RegimeAduaneiroTipoDocumentos',
        'app.RegimesAduaneiros',
        'app.TipoDocumentos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RegimeAduaneiroTipoDocumentos') ? [] : ['className' => RegimeAduaneiroTipoDocumentosTable::class];
        $this->RegimeAduaneiroTipoDocumentos = TableRegistry::getTableLocator()->get('RegimeAduaneiroTipoDocumentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RegimeAduaneiroTipoDocumentos);

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
