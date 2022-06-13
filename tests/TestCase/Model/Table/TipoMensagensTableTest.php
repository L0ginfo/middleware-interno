<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TipoMensagensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TipoMensagensTable Test Case
 */
class TipoMensagensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TipoMensagensTable
     */
    public $TipoMensagens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TipoMensagens',
        'app.Mensagens',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TipoMensagens') ? [] : ['className' => TipoMensagensTable::class];
        $this->TipoMensagens = TableRegistry::getTableLocator()->get('TipoMensagens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TipoMensagens);

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
