<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GradeHorariosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GradeHorariosTable Test Case
 */
class GradeHorariosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GradeHorariosTable
     */
    public $GradeHorarios;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.GradeHorarios',
        'app.Operacoes',
        'app.RegimesAduaneiros',
        'app.Produtos',
        'app.DriveEspacoTipos',
        'app.DriveEspacoClassificacoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('GradeHorarios') ? [] : ['className' => GradeHorariosTable::class];
        $this->GradeHorarios = TableRegistry::getTableLocator()->get('GradeHorarios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->GradeHorarios);

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
