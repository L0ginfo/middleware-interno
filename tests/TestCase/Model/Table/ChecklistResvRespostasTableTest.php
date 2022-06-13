<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChecklistResvRespostasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChecklistResvRespostasTable Test Case
 */
class ChecklistResvRespostasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ChecklistResvRespostasTable
     */
    public $ChecklistResvRespostas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ChecklistResvRespostas',
        'app.ChecklistResvs',
        'app.ChecklistPerguntaRespostas',
        'app.ChecklistResvPerguntas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ChecklistResvRespostas') ? [] : ['className' => ChecklistResvRespostasTable::class];
        $this->ChecklistResvRespostas = TableRegistry::getTableLocator()->get('ChecklistResvRespostas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ChecklistResvRespostas);

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
