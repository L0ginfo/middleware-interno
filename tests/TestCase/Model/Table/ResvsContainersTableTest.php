<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResvsContainersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResvsContainersTable Test Case
 */
class ResvsContainersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ResvsContainersTable
     */
    public $ResvsContainers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ResvsContainers',
        'app.Containers',
        'app.DocumentosTransportes',
        'app.Resvs',
        'app.Operacoes',
        'app.Empresas',
        'app.LiberacoesDocumentais',
        'app.Bookings',
        'app.DocumentoGenericos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ResvsContainers') ? [] : ['className' => ResvsContainersTable::class];
        $this->ResvsContainers = TableRegistry::getTableLocator()->get('ResvsContainers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResvsContainers);

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
