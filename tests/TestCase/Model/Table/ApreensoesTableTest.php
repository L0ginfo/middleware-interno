<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ApreensoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ApreensoesTable Test Case
 */
class ApreensoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ApreensoesTable
     */
    public $Apreensoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Apreensoes',
        'app.DocumentosMercadorias',
        'app.Empresas',
        'app.Aftns',
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
        $config = TableRegistry::getTableLocator()->exists('Apreensoes') ? [] : ['className' => ApreensoesTable::class];
        $this->Apreensoes = TableRegistry::getTableLocator()->get('Apreensoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Apreensoes);

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
