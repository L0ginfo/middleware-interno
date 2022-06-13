<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GradeHorarioLiberacaoTransportadorasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GradeHorarioLiberacaoTransportadorasTable Test Case
 */
class GradeHorarioLiberacaoTransportadorasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GradeHorarioLiberacaoTransportadorasTable
     */
    public $GradeHorarioLiberacaoTransportadoras;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.GradeHorarioLiberacaoTransportadoras',
        'app.Transportadoras',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('GradeHorarioLiberacaoTransportadoras') ? [] : ['className' => GradeHorarioLiberacaoTransportadorasTable::class];
        $this->GradeHorarioLiberacaoTransportadoras = TableRegistry::getTableLocator()->get('GradeHorarioLiberacaoTransportadoras', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->GradeHorarioLiberacaoTransportadoras);

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
