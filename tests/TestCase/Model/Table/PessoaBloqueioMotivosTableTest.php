<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PessoaBloqueioMotivosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PessoaBloqueioMotivosTable Test Case
 */
class PessoaBloqueioMotivosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PessoaBloqueioMotivosTable
     */
    public $PessoaBloqueioMotivos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PessoaBloqueioMotivos',
        'app.PessoaBloqueios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PessoaBloqueioMotivos') ? [] : ['className' => PessoaBloqueioMotivosTable::class];
        $this->PessoaBloqueioMotivos = TableRegistry::getTableLocator()->get('PessoaBloqueioMotivos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PessoaBloqueioMotivos);

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
