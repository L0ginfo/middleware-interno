<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TipoAcessosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TipoAcessosTable Test Case
 */
class TipoAcessosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TipoAcessosTable
     */
    public $TipoAcessos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TipoAcessos',
        'app.ControleAcessoCodigos',
        'app.ControleAcessoLogs',
        'app.CredenciamentoPerfis',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TipoAcessos') ? [] : ['className' => TipoAcessosTable::class];
        $this->TipoAcessos = TableRegistry::getTableLocator()->get('TipoAcessos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TipoAcessos);

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
