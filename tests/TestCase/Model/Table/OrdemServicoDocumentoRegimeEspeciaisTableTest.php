<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdemServicoDocumentoRegimeEspeciaisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdemServicoDocumentoRegimeEspeciaisTable Test Case
 */
class OrdemServicoDocumentoRegimeEspeciaisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdemServicoDocumentoRegimeEspeciaisTable
     */
    public $OrdemServicoDocumentoRegimeEspeciais;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OrdemServicoDocumentoRegimeEspeciais',
        'app.OrdemServicos',
        'app.DocumentoRegimeEspeciais',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OrdemServicoDocumentoRegimeEspeciais') ? [] : ['className' => OrdemServicoDocumentoRegimeEspeciaisTable::class];
        $this->OrdemServicoDocumentoRegimeEspeciais = TableRegistry::getTableLocator()->get('OrdemServicoDocumentoRegimeEspeciais', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrdemServicoDocumentoRegimeEspeciais);

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
