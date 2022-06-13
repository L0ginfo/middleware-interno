<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProgramacaoContainersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProgramacaoContainersTable Test Case
 */
class ProgramacaoContainersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProgramacaoContainersTable
     */
    public $ProgramacaoContainers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ProgramacaoContainers',
        'app.Containers',
        'app.DocumentosTransportes',
        'app.Resvs',
        'app.Operacoes',
        'app.Empresas',
        'app.LiberacoesDocumentais',
        'app.DocumentoGenericos',
        'app.DriveEspacos',
        'app.ProgramacaoContainerLacres',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ProgramacaoContainers') ? [] : ['className' => ProgramacaoContainersTable::class];
        $this->ProgramacaoContainers = TableRegistry::getTableLocator()->get('ProgramacaoContainers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProgramacaoContainers);

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
