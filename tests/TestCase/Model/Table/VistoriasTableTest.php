<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VistoriasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VistoriasTable Test Case
 */
class VistoriasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\VistoriasTable
     */
    public $Vistorias;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Vistorias',
        'app.Resvs',
        'app.Pessoas',
        'app.Veiculos',
        'app.VistoriaTipoCargas',
        'app.VistoriaAvarias',
        'app.VistoriaFotos',
        'app.VistoriaItens',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Vistorias') ? [] : ['className' => VistoriasTable::class];
        $this->Vistorias = TableRegistry::getTableLocator()->get('Vistorias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Vistorias);

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
