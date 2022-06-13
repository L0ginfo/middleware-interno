<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MapaTransacaoTiposTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MapaTransacaoTiposTable Test Case
 */
class MapaTransacaoTiposTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MapaTransacaoTiposTable
     */
    public $MapaTransacaoTipos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MapaTransacaoTipos',
        'app.MapaTransacaoHistoricos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MapaTransacaoTipos') ? [] : ['className' => MapaTransacaoTiposTable::class];
        $this->MapaTransacaoTipos = TableRegistry::getTableLocator()->get('MapaTransacaoTipos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MapaTransacaoTipos);

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
