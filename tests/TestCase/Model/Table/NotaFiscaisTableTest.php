<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NotaFiscaisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NotaFiscaisTable Test Case
 */
class NotaFiscaisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\NotaFiscaisTable
     */
    public $NotaFiscais;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.NotaFiscais',
        'app.NotaFiscalTipos',
        'app.NotaFiscalCfops',
        'app.ResvNotas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('NotaFiscais') ? [] : ['className' => NotaFiscaisTable::class];
        $this->NotaFiscais = TableRegistry::getTableLocator()->get('NotaFiscais', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NotaFiscais);

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
