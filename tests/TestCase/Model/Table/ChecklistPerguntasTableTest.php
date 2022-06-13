<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChecklistPerguntasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChecklistPerguntasTable Test Case
 */
class ChecklistPerguntasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ChecklistPerguntasTable
     */
    public $ChecklistPerguntas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ChecklistPerguntas',
        'app.Checklists',
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
        $config = TableRegistry::getTableLocator()->exists('ChecklistPerguntas') ? [] : ['className' => ChecklistPerguntasTable::class];
        $this->ChecklistPerguntas = TableRegistry::getTableLocator()->get('ChecklistPerguntas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ChecklistPerguntas);

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
