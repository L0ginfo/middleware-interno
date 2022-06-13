<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TributosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TributosTable Test Case
 */
class TributosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TributosTable
     */
    public $Tributos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Tributos',
        'app.DocumentoRegimeEspecialTributos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Tributos') ? [] : ['className' => TributosTable::class];
        $this->Tributos = TableRegistry::getTableLocator()->get('Tributos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tributos);

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
