<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EnderecoMedicoesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EnderecoMedicoesTable Test Case
 */
class EnderecoMedicoesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EnderecoMedicoesTable
     */
    public $EnderecoMedicoes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EnderecoMedicoes',
        'app.EnderecoMedicaoDados',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EnderecoMedicoes') ? [] : ['className' => EnderecoMedicoesTable::class];
        $this->EnderecoMedicoes = TableRegistry::getTableLocator()->get('EnderecoMedicoes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EnderecoMedicoes);

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
