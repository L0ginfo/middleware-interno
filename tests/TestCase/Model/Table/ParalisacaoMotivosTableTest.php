<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ParalisacaoMotivosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ParalisacaoMotivosTable Test Case
 */
class ParalisacaoMotivosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ParalisacaoMotivosTable
     */
    public $ParalisacaoMotivos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ParalisacaoMotivos',
        'app.Paralisacoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ParalisacaoMotivos') ? [] : ['className' => ParalisacaoMotivosTable::class];
        $this->ParalisacaoMotivos = TableRegistry::getTableLocator()->get('ParalisacaoMotivos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ParalisacaoMotivos);

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
