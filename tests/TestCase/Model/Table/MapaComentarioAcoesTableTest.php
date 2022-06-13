<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MapaComentarioAcoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MapaComentarioAcoesTable Test Case
 */
class MapaComentarioAcoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MapaComentarioAcoesTable
     */
    public $MapaComentarioAcoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MapaComentarioAcoes',
        'app.MapaComentarios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MapaComentarioAcoes') ? [] : ['className' => MapaComentarioAcoesTable::class];
        $this->MapaComentarioAcoes = TableRegistry::getTableLocator()->get('MapaComentarioAcoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MapaComentarioAcoes);

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
}
