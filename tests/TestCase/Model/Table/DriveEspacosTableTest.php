<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DriveEspacosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DriveEspacosTable Test Case
 */
class DriveEspacosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DriveEspacosTable
     */
    public $DriveEspacos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DriveEspacos',
        'app.Empresas',
        'app.ContainerTamanhos',
        'app.TipoIsos',
        'app.Operacoes',
        'app.DriveEspacoClassificacoes',
        'app.DriveEspacoTipos',
        'app.UnidadeMedidas',
        'app.ResvsContainers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DriveEspacos') ? [] : ['className' => DriveEspacosTable::class];
        $this->DriveEspacos = TableRegistry::getTableLocator()->get('DriveEspacos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DriveEspacos);

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
