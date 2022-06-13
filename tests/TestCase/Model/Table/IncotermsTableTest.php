<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\IncotermsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\IncotermsTable Test Case
 */
class IncotermsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\IncotermsTable
     */
    public $Incoterms;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Incoterms',
        'app.DocumentoRegimeEspecialAdicoes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Incoterms') ? [] : ['className' => IncotermsTable::class];
        $this->Incoterms = TableRegistry::getTableLocator()->get('Incoterms', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Incoterms);

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
