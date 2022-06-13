<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NotaFiscalConhecimentosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NotaFiscalConhecimentosTable Test Case
 */
class NotaFiscalConhecimentosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\NotaFiscalConhecimentosTable
     */
    public $NotaFiscalConhecimentos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.NotaFiscalConhecimentos',
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
        $config = TableRegistry::getTableLocator()->exists('NotaFiscalConhecimentos') ? [] : ['className' => NotaFiscalConhecimentosTable::class];
        $this->NotaFiscalConhecimentos = TableRegistry::getTableLocator()->get('NotaFiscalConhecimentos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NotaFiscalConhecimentos);

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
