<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChecklistPerguntaRespostasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChecklistPerguntaRespostasTable Test Case
 */
class ChecklistPerguntaRespostasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ChecklistPerguntaRespostasTable
     */
    public $ChecklistPerguntaRespostas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ChecklistPerguntaRespostas',
        'app.ChecklistPerguntas',
        'app.ChecklistResvRespostas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ChecklistPerguntaRespostas') ? [] : ['className' => ChecklistPerguntaRespostasTable::class];
        $this->ChecklistPerguntaRespostas = TableRegistry::getTableLocator()->get('ChecklistPerguntaRespostas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ChecklistPerguntaRespostas);

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
