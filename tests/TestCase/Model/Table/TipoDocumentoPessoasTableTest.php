<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TipoDocumentoPessoasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TipoDocumentoPessoasTable Test Case
 */
class TipoDocumentoPessoasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TipoDocumentoPessoasTable
     */
    public $TipoDocumentoPessoas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TipoDocumentoPessoas',
        'app.Pessoas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TipoDocumentoPessoas') ? [] : ['className' => TipoDocumentoPessoasTable::class];
        $this->TipoDocumentoPessoas = TableRegistry::getTableLocator()->get('TipoDocumentoPessoas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TipoDocumentoPessoas);

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
