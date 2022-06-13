<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RetencoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RetencoesTable Test Case
 */
class RetencoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RetencoesTable
     */
    public $Retencoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Retencoes',
        'app.Empresas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Retencoes') ? [] : ['className' => RetencoesTable::class];
        $this->Retencoes = TableRegistry::getTableLocator()->get('Retencoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Retencoes);

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
