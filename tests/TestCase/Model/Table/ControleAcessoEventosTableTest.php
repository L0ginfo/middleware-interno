<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ControleAcessoEventosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ControleAcessoEventosTable Test Case
 */
class ControleAcessoEventosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ControleAcessoEventosTable
     */
    public $ControleAcessoEventos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ControleAcessoEventos',
        'app.ControleAcessoLogs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ControleAcessoEventos') ? [] : ['className' => ControleAcessoEventosTable::class];
        $this->ControleAcessoEventos = TableRegistry::getTableLocator()->get('ControleAcessoEventos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ControleAcessoEventos);

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
