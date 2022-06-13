<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CancelaAcoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CancelaAcoesTable Test Case
 */
class CancelaAcoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CancelaAcoesTable
     */
    public $CancelaAcoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CancelaAcoes',
        'app.CancelaAcaoPermitidas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CancelaAcoes') ? [] : ['className' => CancelaAcoesTable::class];
        $this->CancelaAcoes = TableRegistry::getTableLocator()->get('CancelaAcoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CancelaAcoes);

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
