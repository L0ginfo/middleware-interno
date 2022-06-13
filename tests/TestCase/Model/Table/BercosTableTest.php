<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BercosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BercosTable Test Case
 */
class BercosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BercosTable
     */
    public $Bercos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Bercos',
        'app.PlanejamentoMaritimos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Bercos') ? [] : ['className' => BercosTable::class];
        $this->Bercos = TableRegistry::getTableLocator()->get('Bercos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Bercos);

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
