<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChecklistPerguntaFotosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChecklistPerguntaFotosTable Test Case
 */
class ChecklistPerguntaFotosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ChecklistPerguntaFotosTable
     */
    public $ChecklistPerguntaFotos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ChecklistPerguntaFotos',
        'app.Anexos',
        'app.ChecklistResvs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ChecklistPerguntaFotos') ? [] : ['className' => ChecklistPerguntaFotosTable::class];
        $this->ChecklistPerguntaFotos = TableRegistry::getTableLocator()->get('ChecklistPerguntaFotos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ChecklistPerguntaFotos);

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
