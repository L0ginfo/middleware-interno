<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FeriadosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FeriadosTable Test Case
 */
class FeriadosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FeriadosTable
     */
    public $Feriados;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Feriados'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Feriados') ? [] : ['className' => FeriadosTable::class];
        $this->Feriados = TableRegistry::getTableLocator()->get('Feriados', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Feriados);

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
