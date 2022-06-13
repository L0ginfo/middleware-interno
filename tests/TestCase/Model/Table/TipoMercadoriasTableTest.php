<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TipoMercadoriasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TipoMercadoriasTable Test Case
 */
class TipoMercadoriasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TipoMercadoriasTable
     */
    public $TipoMercadorias;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TipoMercadorias',
        'app.DocumentosMercadorias'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TipoMercadorias') ? [] : ['className' => TipoMercadoriasTable::class];
        $this->TipoMercadorias = TableRegistry::getTableLocator()->get('TipoMercadorias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TipoMercadorias);

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
