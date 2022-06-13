<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PesagemTiposTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PesagemTiposTable Test Case
 */
class PesagemTiposTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PesagemTiposTable
     */
    public $PesagemTipos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PesagemTipos',
        'app.PesagemVeiculos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PesagemTipos') ? [] : ['className' => PesagemTiposTable::class];
        $this->PesagemTipos = TableRegistry::getTableLocator()->get('PesagemTipos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PesagemTipos);

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
