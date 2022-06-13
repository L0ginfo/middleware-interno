<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChecklistResvsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChecklistResvsTable Test Case
 */
class ChecklistResvsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ChecklistResvsTable
     */
    public $ChecklistResvs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ChecklistResvs',
        'app.Resvs',
        'app.Checklists',
        'app.ChecklistPerguntaFotos',
        'app.ChecklistResvPerguntas',
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
        $config = TableRegistry::getTableLocator()->exists('ChecklistResvs') ? [] : ['className' => ChecklistResvsTable::class];
        $this->ChecklistResvs = TableRegistry::getTableLocator()->get('ChecklistResvs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ChecklistResvs);

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
