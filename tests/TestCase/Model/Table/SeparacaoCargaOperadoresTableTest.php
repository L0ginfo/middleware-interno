<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SeparacaoCargaOperadoresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SeparacaoCargaOperadoresTable Test Case
 */
class SeparacaoCargaOperadoresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SeparacaoCargaOperadoresTable
     */
    public $SeparacaoCargaOperadores;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.SeparacaoCargaOperadores',
        'app.Usuarios',
        'app.SeparacaoCargas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SeparacaoCargaOperadores') ? [] : ['className' => SeparacaoCargaOperadoresTable::class];
        $this->SeparacaoCargaOperadores = TableRegistry::getTableLocator()->get('SeparacaoCargaOperadores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SeparacaoCargaOperadores);

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
