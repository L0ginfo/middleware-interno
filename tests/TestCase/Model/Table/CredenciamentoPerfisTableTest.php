<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CredenciamentoPerfisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CredenciamentoPerfisTable Test Case
 */
class CredenciamentoPerfisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CredenciamentoPerfisTable
     */
    public $CredenciamentoPerfis;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CredenciamentoPerfis',
        'app.Perfis',
        'app.TipoAcessos',
        'app.CredenciamentoPessoas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CredenciamentoPerfis') ? [] : ['className' => CredenciamentoPerfisTable::class];
        $this->CredenciamentoPerfis = TableRegistry::getTableLocator()->get('CredenciamentoPerfis', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CredenciamentoPerfis);

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
