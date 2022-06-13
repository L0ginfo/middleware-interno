<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MensagensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MensagensTable Test Case
 */
class MensagensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MensagensTable
     */
    public $Mensagens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Mensagens',
        'app.TipoMensagens',
        'app.Usuarios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Mensagens') ? [] : ['className' => MensagensTable::class];
        $this->Mensagens = TableRegistry::getTableLocator()->get('Mensagens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Mensagens);

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
