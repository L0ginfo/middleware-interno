<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PessoaBloqueiosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PessoaBloqueiosTable Test Case
 */
class PessoaBloqueiosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PessoaBloqueiosTable
     */
    public $PessoaBloqueios;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PessoaBloqueios',
        'app.Pessoas',
        'app.PessoaBloqueioMotivos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PessoaBloqueios') ? [] : ['className' => PessoaBloqueiosTable::class];
        $this->PessoaBloqueios = TableRegistry::getTableLocator()->get('PessoaBloqueios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PessoaBloqueios);

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
