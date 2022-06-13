<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ControleAcessoControladorasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ControleAcessoControladorasTable Test Case
 */
class ControleAcessoControladorasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ControleAcessoControladorasTable
     */
    public $ControleAcessoControladoras;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ControleAcessoControladoras',
        'app.ControleAcessoAreas',
        'app.DirecaoControladoras',
        'app.ModeloEquipamentos',
        'app.TipoEquipamentos',
        'app.ControleAcessoLogs',
        'app.ControleAcessoSolicitacaoLeituras',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ControleAcessoControladoras') ? [] : ['className' => ControleAcessoControladorasTable::class];
        $this->ControleAcessoControladoras = TableRegistry::getTableLocator()->get('ControleAcessoControladoras', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ControleAcessoControladoras);

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
