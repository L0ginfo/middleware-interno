<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ControleAcessoControladoraLeitorasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ControleAcessoControladoraLeitorasTable Test Case
 */
class ControleAcessoControladoraLeitorasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ControleAcessoControladoraLeitorasTable
     */
    public $ControleAcessoControladoraLeitoras;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ControleAcessoControladoraLeitoras',
        'app.ControleAcessoControladoras',
        'app.ControleAcessoEquipamentos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ControleAcessoControladoraLeitoras') ? [] : ['className' => ControleAcessoControladoraLeitorasTable::class];
        $this->ControleAcessoControladoraLeitoras = TableRegistry::getTableLocator()->get('ControleAcessoControladoraLeitoras', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ControleAcessoControladoraLeitoras);

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
