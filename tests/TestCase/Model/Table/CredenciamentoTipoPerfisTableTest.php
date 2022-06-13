<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CredenciamentoTipoPerfisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CredenciamentoTipoPerfisTable Test Case
 */
class CredenciamentoTipoPerfisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CredenciamentoTipoPerfisTable
     */
    public $CredenciamentoTipoPerfis;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CredenciamentoTipoPerfis',
        'app.CredenciamentoPerfis',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CredenciamentoTipoPerfis') ? [] : ['className' => CredenciamentoTipoPerfisTable::class];
        $this->CredenciamentoTipoPerfis = TableRegistry::getTableLocator()->get('CredenciamentoTipoPerfis', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CredenciamentoTipoPerfis);

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
