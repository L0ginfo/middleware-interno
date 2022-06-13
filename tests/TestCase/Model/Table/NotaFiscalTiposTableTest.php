<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NotaFiscalTiposTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NotaFiscalTiposTable Test Case
 */
class NotaFiscalTiposTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\NotaFiscalTiposTable
     */
    public $NotaFiscalTipos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.NotaFiscalTipos',
        'app.NotaFiscais',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('NotaFiscalTipos') ? [] : ['className' => NotaFiscalTiposTable::class];
        $this->NotaFiscalTipos = TableRegistry::getTableLocator()->get('NotaFiscalTipos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NotaFiscalTipos);

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
