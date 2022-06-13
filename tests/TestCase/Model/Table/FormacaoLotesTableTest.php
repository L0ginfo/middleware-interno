<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FormacaoLotesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FormacaoLotesTable Test Case
 */
class FormacaoLotesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FormacaoLotesTable
     */
    public $FormacaoLotes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FormacaoLotes',
        'app.DocumentosTransportes',
        'app.FormacaoLoteItens',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FormacaoLotes') ? [] : ['className' => FormacaoLotesTable::class];
        $this->FormacaoLotes = TableRegistry::getTableLocator()->get('FormacaoLotes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FormacaoLotes);

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
