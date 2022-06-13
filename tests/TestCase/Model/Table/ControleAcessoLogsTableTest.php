<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ControleAcessoLogsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ControleAcessoLogsTable Test Case
 */
class ControleAcessoLogsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ControleAcessoLogsTable
     */
    public $ControleAcessoLogs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ControleAcessoLogs',
        'app.ControleAcessoControladoras',
        'app.AreaDes',
        'app.AreaParas',
        'app.DirecaoControladoras',
        'app.TipoAcessos',
        'app.CredenciamentoPessoas',
        'app.ControleAcessoEventos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ControleAcessoLogs') ? [] : ['className' => ControleAcessoLogsTable::class];
        $this->ControleAcessoLogs = TableRegistry::getTableLocator()->get('ControleAcessoLogs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ControleAcessoLogs);

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
