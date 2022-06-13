<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CredenciamentoPerfilAreasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CredenciamentoPerfilAreasTable Test Case
 */
class CredenciamentoPerfilAreasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CredenciamentoPerfilAreasTable
     */
    public $CredenciamentoPerfilAreas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CredenciamentoPerfilAreas',
        'app.CredenciamentoPerfis',
        'app.ControleAcessoAreas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CredenciamentoPerfilAreas') ? [] : ['className' => CredenciamentoPerfilAreasTable::class];
        $this->CredenciamentoPerfilAreas = TableRegistry::getTableLocator()->get('CredenciamentoPerfilAreas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CredenciamentoPerfilAreas);

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
