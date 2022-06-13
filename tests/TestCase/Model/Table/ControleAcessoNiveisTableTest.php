<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ControleAcessoNiveisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ControleAcessoNiveisTable Test Case
 */
class ControleAcessoNiveisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ControleAcessoNiveisTable
     */
    public $ControleAcessoNiveis;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ControleAcessoNiveis',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ControleAcessoNiveis') ? [] : ['className' => ControleAcessoNiveisTable::class];
        $this->ControleAcessoNiveis = TableRegistry::getTableLocator()->get('ControleAcessoNiveis', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ControleAcessoNiveis);

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
