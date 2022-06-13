<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ParalisacaoResponsaveisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ParalisacaoResponsaveisTable Test Case
 */
class ParalisacaoResponsaveisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ParalisacaoResponsaveisTable
     */
    public $ParalisacaoResponsaveis;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ParalisacaoResponsaveis',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ParalisacaoResponsaveis') ? [] : ['className' => ParalisacaoResponsaveisTable::class];
        $this->ParalisacaoResponsaveis = TableRegistry::getTableLocator()->get('ParalisacaoResponsaveis', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ParalisacaoResponsaveis);

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
