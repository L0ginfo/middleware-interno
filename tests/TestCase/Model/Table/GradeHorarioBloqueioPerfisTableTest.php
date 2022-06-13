<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GradeHorarioBloqueioPerfisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GradeHorarioBloqueioPerfisTable Test Case
 */
class GradeHorarioBloqueioPerfisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GradeHorarioBloqueioPerfisTable
     */
    public $GradeHorarioBloqueioPerfis;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.GradeHorarioBloqueioPerfis',
        'app.GradeHorarios',
        'app.Perfis',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('GradeHorarioBloqueioPerfis') ? [] : ['className' => GradeHorarioBloqueioPerfisTable::class];
        $this->GradeHorarioBloqueioPerfis = TableRegistry::getTableLocator()->get('GradeHorarioBloqueioPerfis', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->GradeHorarioBloqueioPerfis);

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
