<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ViagensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ViagensTable Test Case
 */
class ViagensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ViagensTable
     */
    public $Viagens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Viagens',
        'app.Transportadoras',
        'app.Empresas',
        'app.Modais',
        'app.Operadores',
        'app.Programacoes',
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
        $config = TableRegistry::getTableLocator()->exists('Viagens') ? [] : ['className' => ViagensTable::class];
        $this->Viagens = TableRegistry::getTableLocator()->get('Viagens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Viagens);

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
