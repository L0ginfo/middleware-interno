<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PesagensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PesagensTable Test Case
 */
class PesagensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PesagensTable
     */
    public $Pesagens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Pesagens',
        'app.Resvs',
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
        $config = TableRegistry::getTableLocator()->exists('Pesagens') ? [] : ['className' => PesagensTable::class];
        $this->Pesagens = TableRegistry::getTableLocator()->get('Pesagens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Pesagens);

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
